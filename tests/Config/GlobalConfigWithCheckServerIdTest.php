<?php

namespace FwolfTest\Config;

use Fwolf\Config\Exception\KeyNotExist;
use Fwolf\Config\GlobalConfigWithCheckServerId;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class GlobalConfigWithCheckServerIdTest extends PHPUnitTestCase
{
    /**
     * @var string|int
     */
    private static $serverIdBackup = null;


    /**
     * @return MockObject | GlobalConfigWithCheckServerId
     */
    protected function buildMock()
    {
        $mock = $this->createMock(GlobalConfigWithCheckServerId::class);

        return $mock;
    }


    public static function setUpBeforeClass()
    {
        $globalConfig = GlobalConfigWithCheckServerId::getInstance();

        try {
            self::$serverIdBackup = $globalConfig->getServerId();

        } catch (KeyNotExist $e) {
            $globalConfig->setServerId(null);
        }
    }


    public static function tearDownAfterClass()
    {
        GlobalConfigWithCheckServerId::getInstance()
            ->setServerId(self::$serverIdBackup);
    }


    public function testAccessors()
    {
        $globalConfig = GlobalConfigWithCheckServerId::getInstance();

        $globalConfig->setServerId(42);
        $this->assertEquals(42, $globalConfig->getServerId());

        $globalConfig->setServerId('foo');
        $this->assertEquals('foo', $globalConfig->getServerId());
    }
}
