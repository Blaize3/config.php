<?php

namespace Fwolf\Config;

use Fwolf\Config\Exception\InvalidFormatException;
use Fwolf\Config\Exception\KeyNotExist;

/**
 * StringOptions
 *
 * Special config with feature:
 *  - Initialize from string
 *  - Get un-defined option will return false(or other configure value)
 *
 * Example of option string:
 *  - "singleValue", will parse to bool value
 *  - "foo, bar=42", multiple value split by separator, default ','
 *  - "foo=42, bar = 24", assignment value, will parse to {key: value}
 *  - "foo = h e l l o", assignment value can contain whitespace
 *  - " foo = a b ", assignment key and value will all be trimmed, {foo: 'a b'}
 *  - "foo = false", explicit boolean type value
 *
 * @copyright   Copyright 2015-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class StringOptions extends Config
{
    /**
     * Separator between key and value, eg: 'foo=bar' or 'foo: bar'
     */
    const KV_SEPARATOR = '=';

    /**
     * Separator between key or key-value pairs in option string.
     */
    const OPTION_SEPARATOR = ',';

    /**
     * For eye candy, whitespace may inserted after option separator.
     * Only for export.
     */
    const WHITESPACE_AFTER_OPTION_SEPARATOR = ' ';

    /**
     * Value of option only have name
     */
    const NAME_ONLY_VALUE = true;

    /**
     * Value of un-defined option
     */
    const FALLBACK_VALUE = false;


    /**
     * @param   string $optionString
     * @param   string $optionSeparator
     * @param   string $kvSeparator
     */
    public function __construct(
        $optionString = '',
        $optionSeparator = null,
        $kvSeparator = null
    ) {
        if (!empty($optionString)) {
            $this->import($optionString, $optionSeparator, $kvSeparator);
        }
    }


    /**
     * Export options back to string
     *
     * Whitespace is added after each separators.
     *
     * @param   string $optionSeparator
     * @param   string $kvSeparator
     * @return  string
     */
    public function export($optionSeparator = null, $kvSeparator = null)
    {
        if (is_null($optionSeparator)) {
            $optionSeparator = static::OPTION_SEPARATOR;
        }

        if (is_null($kvSeparator)) {
            $kvSeparator = static::KV_SEPARATOR;
        }

        $sections = [];

        foreach ($this->getRaw() as $key => $value) {
            if (true === $value) {
                $value = 'true';
            } elseif (false === $value) {
                $value = 'false';
            }

            $sections[] = "{$key}{$kvSeparator}{$value}";
        }

        $whitespace = static::WHITESPACE_AFTER_OPTION_SEPARATOR;

        return implode($optionSeparator . $whitespace, $sections);
    }


    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        try {
            $value = parent::get($key);

        } catch (KeyNotExist $e) {
            $value = static::FALLBACK_VALUE;
        }

        return $value;
    }


    /**
     * Initialize from option string
     *
     * Will clear present values.
     *
     * @param   string $optionString
     * @param   string $optionSeparator
     * @param   string $kvSeparator
     * @return  $this
     * @throws  InvalidFormatException
     */
    public function import(
        $optionString = '',
        $optionSeparator = null,
        $kvSeparator = null
    ) {
        if (is_null($optionSeparator)) {
            $optionSeparator = static::OPTION_SEPARATOR;
        }

        if (is_null($kvSeparator)) {
            $kvSeparator = static::KV_SEPARATOR;
        }

        $this->configs = [];

        $sections = explode($optionSeparator, $optionString);
        foreach ($sections as $section) {
            $kvPair = explode($kvSeparator, $section);

            if (1 == count($kvPair)) {
                // Option name only
                $key = trim(current($kvPair));

                // Continues repeat separator will cause empty value like this
                if ('' === $key) {
                    continue;
                }

                // No value part
                $this->set($key, static::NAME_ONLY_VALUE);

            } elseif (2 == count($kvPair)) {
                // Normal key-value pair
                $key = trim(array_shift($kvPair));
                $value = trim(array_shift($kvPair));

                $lowerValue = strtolower($value);
                if ('true' === $lowerValue) {
                    $value = true;
                } elseif ('false' === $lowerValue) {
                    $value = false;
                }

                $this->set($key, $value);

            } else {
                throw new InvalidFormatException(
                    "Format error: {$section}"
                );
            }
        }

        return $this;
    }
}
