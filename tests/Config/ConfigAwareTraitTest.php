<?php
namespace FwolfTest\Config;

use Fwolf\Config\ConfigAwareTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ConfigAwareTraitTest extends PHPUnitTestCase
{
    /**
     * @return MockObject | ConfigAwareTrait
     */
    protected function buildMock()
    {
        $mock = $this->getMockBuilder(ConfigAwareTrait::class)
            ->setMethods(null)
            ->getMockForTrait();

        return $mock;
    }


    public function testNormalSetGet()
    {
        $configAware = $this->buildMock();

        $configAware->setConfigs(['prefix.key1' => 10,]);
        $this->assertEquals(10, $configAware->getConfig('prefix.key1'));

        $configAware->setConfig('prefix.key2', 20);
        $this->assertEquals(
            ['key1' => 10, 'key2' => 20],
            $configAware->getConfig('prefix')
        );

        $this->assertEquals($configAware->getConfigs(), [
            'prefix' => [
                'key1' => 10,
                'key2' => 20,
            ],
        ]);
    }
}
