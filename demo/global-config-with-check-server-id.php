<?php
/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */

use Fwolf\Config\GlobalConfigWithCheckServerId;

require __DIR__ . '/../bootstrap.php';


$eol = ('cli' == PHP_SAPI) ? PHP_EOL : "<br />\n";


$globalConfig = GlobalConfigWithCheckServerId::getInstance();

$globalConfig->setServerId('testServer');


echo "Is this production server ?" . $eol;
// false
echo json_encode('productionServer' == $globalConfig->getServerId()) . $eol;


if ($globalConfig->isServerIdAllowed('testServer')) {
    echo 'This is test server' . $eol;
}


try {
    $globalConfig->requireServerId('productionServer');
    // Do something
} catch (\Exception $e) {
    echo 'This is not production server' . $eol;
}
