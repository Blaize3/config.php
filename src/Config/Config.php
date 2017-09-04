<?php

namespace Fwolf\Config;

use Fwolf\Config\Exception\KeyNotExist;
use Fwolf\Config\Exception\ReachLeafNode;

/**
 * Config class
 *
 *
 * Config keys can have hierarchy, split by separator.
 *
 * Eg: There are config with keys below:
 *  - foo.bar1 = 1
 *  - foo.bar2 = 2
 *  - foo.bar3 = 3
 *
 * While key foo.barN have their own value(1, 2 or 3), key foo can also be used
 * standalone, with associate array value {bar1 => 1, bar2 => 2, bar3 => 3}.
 *
 *
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class Config implements ConfigInterface
{
    /**
     * Separator for config key sections
     */
    const SEPARATOR = '.';


    /**
     * Config data array
     *
     * @var array
     */
    protected $configs = [];


    /**
     * {@inheritdoc}
     *
     * When delete a node with leaf, all leaves(sub tree) are deleted too.
     *
     * Even all leaf node deleted, empty parent node still exists.
     */
    public function delete($key)
    {
        if (false === strpos($key, static::SEPARATOR)) {
            unset($this->configs[$key]);

        } else {
            // Goto deepest parent node, then delete remain key
            $sections = explode(static::SEPARATOR, $key);
            $configPointer = &$this->configs;

            while (1 < count($sections)) {
                $currentKey = array_shift($sections);

                if (isset($configPointer[$currentKey])) {
                    $configPointer = &$configPointer[$currentKey];

                } else {
                    break;
                }
            }

            unset($configPointer[implode(static::SEPARATOR, $sections)]);
        }

        return $this;
    }


    /**
     * {@inheritdoc}
     *
     * Return array when get parent nodes.
     *
     * @throws  KeyNotExist
     */
    public function get($key)
    {
        if (false === strpos($key, static::SEPARATOR)) {
            if (key_exists($key, $this->configs)) {
                return $this->configs[$key];
            } else {
                throw new KeyNotExist("Key '$key' not found");
            }

        } else {
            // Check through each level
            $sections = explode(static::SEPARATOR, $key);
            $configPointer = $this->configs;

            // Loop match value, each loop go deeper in multi-dimension array
            foreach ($sections as $section) {
                if (key_exists($section, $configPointer)) {
                    $configPointer = $configPointer[$section];
                } else {
                    throw new KeyNotExist("Key '$key' not found");
                }
            }

            return ($configPointer);
        }
    }


    /**
     * {@inheritdoc}
     *
     * Result maybe multi dimension array.
     */
    public function getRaw()
    {
        return $this->configs;
    }


    /**
     * {@inheritdoc}
     */
    public function load(array $configData)
    {
        $this->configs = [];

        if (!empty($configData)) {
            $this->setMultiple($configData);
        }

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        try {
            $this->get($offset);
        } catch (KeyNotExist $e) {
            return false;
        }

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }


    /**
     * {@inheritdoc}
     *
     * If $key include separator, will convert to array by it recurrently.
     *
     * Eg: system.format.time => $this->config['system']['format']['time']
     *
     * Notice: This is extend of config key, do not confuse with config value
     * which is already array, although they may have same result.
     */
    public function set($key, $value)
    {
        if (false === strpos($key, static::SEPARATOR)) {
            $this->configs[$key] = $value;

        } else {
            // Recognize separator
            $sections = explode(static::SEPARATOR, $key);
            $parentLevels = count($sections) - 1;
            $configPointer = &$this->configs;

            // Check and create middle level for multi-dimension array
            // Pointer change every loop, goes deeper to sub array
            for ($i = 0; $i < $parentLevels; $i++) {
                $currentKey = $sections[$i];

                // 'a.b.c', if b is not set, create it as an empty array
                if (!key_exists($currentKey, $configPointer)) {
                    $configPointer[$currentKey] = [];
                }

                // Go down to next level
                $configPointer = &$configPointer[$currentKey];

                if (!is_array($configPointer)) {
                    $scannedKeys = array_slice($sections, 0, $i + 1);
                    $scannedKeyStr = implode(static::SEPARATOR, $scannedKeys);
                    throw new ReachLeafNode(
                        "Key '$scannedKeyStr' has assigned single value, " .
                        "did not accept array/multiple value assign"
                    );
                }
            }

            // At last level, set the value
            $configPointer[$sections[$parentLevels]] = $value;
        }

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function setMultiple(array $configData)
    {
        foreach ($configData as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }
}
