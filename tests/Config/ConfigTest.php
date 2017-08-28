<?php

namespace FwolfTest\Config;

use Fwolf\Config\Config;
use Fwolf\Config\Exception\KeyNotExist;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ConfigTest extends PHPUnitTestCase
{
    /**
     * @return  MockObject | Config
     */
    protected function buildMock()
    {
        $mock = $this->createPartialMock(Config::class, null);

        return $mock;
    }


    public function testAccessorWithDotKey()
    {
        $config = new Config();

        // Stored data is array has dot in key
        $foo = ['c.d' => 'foo'];    // This key will NOT be extended
        $config->set('a.b', $foo);  // This key will be extended
        $this->assertEquals($foo, $config->get('a.b'));
        $this->assertArrayHasKey('b', $config->get('a'));

        // Delete fail, key 'c' not exists
        $config->delete('a.b.c');
        $this->assertEquals($foo, $config->get('a.b'));

        // Actual delete
        $config->delete('a');
        $this->assertEquals([], $config->getRaw());
    }


    public function testAccessorsSimple()
    {
        $config = new Config;

        $config->set('foo', 'bar');
        $this->assertEquals('bar', $config->get('foo'));

        $config->setMultiple(['foo' => 2, 'bar.tar' => '3']);
        $this->assertEquals(2, $config->get('foo'));
        $this->assertEquals(3, $config->get('bar.tar'));
    }


    /**
     * Delete all child key will leave an empty parent
     */
    public function testDeleteAllChild()
    {
        $config = new Config();

        $config->set('foo.bar', 2);
        $config->set('foo.tar', 4);
        $this->assertEquals(4, $config->get('foo.tar'));

        // Delete un-exists key does nothing
        $config->delete('foo.bar.tar');
        $config->delete('bar.tar');

        $config->delete('foo.bar');
        $config->delete('foo.tar');
        $this->assertEquals([], $config->get('foo'));
        $this->assertTrue($config->offsetExists('foo'));
        $this->assertFalse($config->offsetExists('foo.bar'));
    }


    /**
     * Delete middle key cause all child disappear
     */
    public function testDeleteFromMiddle()
    {
        $this->expectException(KeyNotExist::class);

        $config = new Config();

        $config->set('foo.bar.tar', 42);
        $this->assertEquals(42, $config->get('foo.bar.tar'));

        $config->delete('foo.bar');
        $config->get('foo.bar.tar');
    }


    public function testDeleteFromSingle()
    {
        $this->expectException(KeyNotExist::class);

        $config = new Config();

        $config->set('foo', 'bar');
        $this->assertEquals('bar', $config->get('foo'));

        $config->delete('foo');
        $config->get('foo');
    }


    public function testSetGet()
    {
        $config = new Config;

        // Single value
        $config->set('foo', 'bar');
        $this->assertEquals($config->get('foo'), 'bar');
        $this->assertFalse(isset($config['foo2']));
        $config['foo2'] = 'bar2';
        $this->assertEquals('bar2', $config['foo2']);
        unset($config['foo2']);
        $this->assertFalse(isset($config['foo2']));

        // Value with separator turns to array
        $config->set('foo1.bar', 42);
        $this->assertEquals($config->get('foo1'), ['bar' => 42]);
        $config['foo3.bar'] = 'bar3';
        $this->assertEquals('bar3', $config['foo3.bar']);

        // Value with empty middle level
        $config->set('a.b.c', 42);
        $this->assertEquals($config->get('a.b.c'), 42);
        $this->assertEquals($config->get('a'), [
            'b' => [
                'c' => 42,
            ],
        ]);


        // Set array data
        $configData = [
            'a'     => 1,
            'b.1'   => 2,
            'b.2'   => 3,
            'c.1.1' => 4,
        ];
        // load() will reset all previous set data.
        $config->load($configData);
        $expectedResult = var_export([
            'a' => 1,
            'b' => [
                1 => 2,
                2 => 3,
            ],
            'c' => [
                1 => [
                    1 => 4,
                ],
            ],
        ], true);
        $this->assertEquals(
            $expectedResult,
            var_export($config->getRaw(), true)
        );
    }
}
