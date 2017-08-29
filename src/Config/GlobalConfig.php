<?php

namespace Fwolf\Config;

use Fwolf\Base\Singleton\SingletonTrait;

/**
 * Config class for store global setting
 *
 * This is a Singleton class, should getInstance() then use, it will return a
 * special instance to store global config. These config data should be load at
 * beginning(eg: bootstrap.php), then they are readable anywhere.
 *
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class GlobalConfig extends Config
{
    use SingletonTrait;
}
