<?php

namespace FwolfTest\Config;

use Fwolf\Config\StringOptionsAwareTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2015-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class StringOptionsAwareTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | StringOptionsAwareTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(StringOptionsAwareTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        return $mock;
    }


    public function testSetStringOptions()
    {
        $trait = $this->buildMock();

        $trait->setStringOptions('foo, bar=42');
        $this->assertTrue($trait->getConfig('foo'));
        $this->assertEquals(42, $trait->getConfig('bar'));
    }
}
