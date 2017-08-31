<?php

namespace FwolfTest\Config;

use Fwolf\Config\Exception\InvalidFormatException;
use Fwolf\Config\StringOptions;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2015-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class StringOptionsTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | StringOptions
     */
    protected function buildMock(array $methods = [])
    {
        $mock = $this->createPartialMock(
            StringOptions::class,
            $methods
        );

        return $mock;
    }


    public function testExport()
    {
        $options = $this->buildMock();

        $options->set('foo1', 42)
            ->set('foo2', true)
            ->set('foo3', false);
        $this->assertEquals(
            'foo1: 42; foo2: true; foo3: false',
            $options->export(';', ': ')
        );
        $this->assertEquals(
            'foo1=42, foo2=true, foo3=false',
            $options->export()
        );
    }


    public function testGet()
    {
        $options = $this->buildMock();

        $this->assertNotNull($options->get('notExist'));
        $this->assertTrue(
            StringOptions::FALLBACK_VALUE === $options->get('notExist')
        );
    }


    public function testImport()
    {
        $options = $this->buildMock();

        $options->import(',,foo1 = 4 2 , foo2=true  , foo3 = false');

        $this->assertEquals('4 2', $options->get('foo1'));
        $this->assertTrue($options->get('foo2'));
        $this->assertFalse($options->get('foo3'));
    }


    public function testImportError()
    {
        $this->expectException(InvalidFormatException::class);

        $options = $this->buildMock();

        $options->import('foo == 42', ',', '=');
    }


    public function testOtherSeparatorAndKvSplitter()
    {
        $options = new StringOptions('foo:: 42; bar', ';', '::');

        $this->assertEquals(42, $options->get('foo'));
        $this->assertEquals(
            StringOptions::NAME_ONLY_VALUE,
            $options->get('bar')
        );
    }
}
