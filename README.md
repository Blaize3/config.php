# Config


[![Travis](https://travis-ci.org/fwolf/config.php.svg?branch=master)](https://travis-ci.org/fwolf/config.php)
[![Latest Stable Version](https://poser.pugx.org/fwolf/config/v/stable)](https://packagist.org/packages/fwolf/config)
[![License](https://poser.pugx.org/fwolf/config/license)](https://packagist.org/packages/fwolf/config)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/334aaf4a-84da-49e4-bee3-0b17c99ebfc9/mini.png)](https://insight.sensiolabs.com/projects/334aaf4a-84da-49e4-bee3-0b17c99ebfc9)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fwolf/config.php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fwolf/config.php/?branch=master)


Config class for easy access.



## Install

    composer require fwolf/config



## Usage

Browse `demo/` for example code.


### Config, ConfigAwareTrait

Access config value by key, single or multiple, may have sections.


### GlobalConfig

Application level config instance.


### GlobalConfigWithCheckServerId, CheckServerIdTrait

Restrict behavior by server id.


### StringOptions, StringOptionsAwareTrait

Parse config string like 'foo=42, bar=hello'.



## License

Distribute under the MIT license.
