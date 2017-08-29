<?php

namespace FwolfTest\Config;

use Fwolf\Config\CheckServerIdTrait;
use Fwolf\Config\Exception\ServerIdNotSet;
use Fwolf\Config\Exception\ServerIdProhibited;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class CheckServerIdTraitTest extends PHPUnitTestCase
{
    /**
     * @param   array $methods
     * @return  MockObject | CheckServerIdTrait
     */
    protected function buildMock(array $methods = [])
    {
        $mock = $this->getMockBuilder(CheckServerIdTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        foreach ($methods as $method => $return) {
            $mock->method($method)
                ->willReturn($return);
        }

        return $mock;
    }


    public function testIsServerIdAllowedSuccess()
    {
        $trait = $this->buildMock(['getServerId' => 'foo']);

        $this->assertTrue($trait->isServerIdAllowed('foo'));
        $this->assertTrue($trait->isServerIdAllowed(['bar', 'foo']));
        $this->assertFalse($trait->isServerIdAllowed('bar'));
    }


    public function testIsServerIdAllowedWithIdNotSet()
    {
        $this->expectException(ServerIdNotSet::class);

        $trait = $this->buildMock();

        $trait->isServerIdAllowed('foo');
    }


    public function testRequireServerIdFail()
    {
        $this->expectException(ServerIdProhibited::class);

        $trait = $this->buildMock(['getServerId' => 'foo']);

        $trait->requireServerId('bar');
    }


    public function testRequireServerIdFailWithMultipleIds()
    {
        $this->expectException(ServerIdProhibited::class);

        $trait = $this->buildMock(['getServerId' => 'foo']);

        $trait->requireServerId(['bar', 'tar']);
    }


    public function testRequireServerIdSuccess()
    {
        $trait = $this->buildMock(['getServerId' => 'foo']);

        $trait->requireServerId('foo');
        $trait->requireServerId(['foo']);
    }
}
