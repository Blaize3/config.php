<?php

namespace Fwolf\Config;

/**
 * Trait for Config aware class also accept StringOptions
 *
 * @copyright   Copyright 2015-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait StringOptionsAwareTrait
{
    use ConfigAwareTrait;


    /**
     * @return StringOptions
     */
    protected function getConfigInstance()
    {
        if (is_null($this->configInstance)) {
            $config = new StringOptions();

            $config->setMultiple($this->getDefaultConfigs());

            $this->configInstance = $config;
        }

        return $this->configInstance;
    }


    /**
     * Set options/config with string
     *
     * @param   string $optionString
     * @return  $this
     */
    public function setStringOptions($optionString)
    {
        $config = $this->getConfigInstance();

        $config->setStringOptions($optionString);

        return $this;
    }
}
