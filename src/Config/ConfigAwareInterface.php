<?php
namespace Fwolf\Config;

/**
 * @copyright   Copyright 2015-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ConfigAwareInterface
{
    /**
     * Get config value
     *
     * @param   string $key
     * @return  mixed
     */
    public function getConfig($key);


    /**
     * Get all configs
     *
     * @return  array
     */
    public function getConfigs();


    /**
     * Set single config value
     *
     * @param   string $key
     * @param   mixed  $val
     * @return  $this
     */
    public function setConfig($key, $val);


    /**
     * Batch set config values
     *
     * @param   array $configs
     * @return  $this
     */
    public function setConfigs(array $configs);
}
