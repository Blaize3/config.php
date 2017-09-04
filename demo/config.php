<?php
/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */

use Fwolf\Config\Config;

require __DIR__ . '/../bootstrap.php';


$eol = ('cli' == PHP_SAPI) ? PHP_EOL : "<br />\n";


$config = new Config();

echo "Assign single value" . $eol;
$config->set('foo1', 42);

// Result: 42
echo "Result: " . $config->get('foo1') . $eol;


echo "Assign value with sections" . $eol;
$config->set('foo2.bar1', 'hello');
$config->set('foo2.bar2', 'world');

// Result: {"bar1":"hello","bar2":"world"}
echo "Result: " . json_encode($config->get('foo2')) . $eol;
