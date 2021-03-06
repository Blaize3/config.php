<?php

namespace Fwolf\Config;

use ArrayAccess;

/**
 * Config class
 *
 * Hold config data for easy access, can be used as other class's property.
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ConfigInterface extends ArrayAccess
{
    /**
     * Delete single config value
     *
     * @param   string $key
     * @return  $this
     */
    public function delete($key);


    /**
     * Get single config value
     *
     * @param   string $key
     * @return  mixed
     */
    public function get($key);


    /**
     * Get all config values as array
     *
     * @return  array
     */
    public function getRaw();


    /**
     * Reset all config and set new data
     *
     * @param   array $configData
     * @return  $this
     */
    public function load(array $configData);


    /**
     * Set single config value
     *
     * @param   string $key
     * @param   mixed  $value
     * @return  $this
     */
    public function set($key, $value);


    /**
     * Set multiple config value
     *
     * Config data is assoc array while array key/value is config key/value.
     *
     * @param   array $configData
     * @return  $this
     */
    public function setMultiple(array $configData);
}
