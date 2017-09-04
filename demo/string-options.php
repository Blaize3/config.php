<?php
/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */

use Fwolf\Config\StringOptions;

require __DIR__ . '/../bootstrap.php';


$eol = ('cli' == PHP_SAPI) ? PHP_EOL : "<br />\n";


$config = new StringOptions();

echo "Assign single value" . $eol;
$config->setStringOptions('foo1 = 42');

// Result: 42
echo "Result: " . $config->get('foo1') . $eol;


echo "Assign multiple value" . $eol;
$config->setStringOptions('foo2=hello, foo3');

// Result: "hello"
echo "Result: " . json_encode($config->get('foo2')) . $eol;
// Result: true
echo "Result: " . json_encode($config->get('foo3')) . $eol;


echo "Dump all configuration{$eol}";
// foo1=42, foo2=hello, foo3=true
echo $config->export() . $eol;
