# Semantic UI Library for Yii2

[![Latest Version](https://img.shields.io/github/release/2amigos/yii2-semantic-ui.svg?style=flat-square)](https://github.com/2amigos/yii2-semantic-ui/releases)
[![Software License](https://img.shields.io/badge/license-BSD-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/2amigos/yii2-semantic-ui/master.svg?style=flat-square)](https://travis-ci.org/2amigos/yii2-semantic-ui)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/2amigos/yii2-semantic-ui.svg?style=flat-square)](https://scrutinizer-ci.com/g/2amigos/yii2-semantic-ui/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/2amigos/yii2-semantic-ui.svg?style=flat-square)](https://scrutinizer-ci.com/g/2amigos/yii2-semantic-ui)
[![Total Downloads](https://img.shields.io/packagist/dt/2amigos/yii2-semantic-ui.svg?style=flat-square)](https://packagist.org/packages/2amigos/yii2-semantic-ui)


This is the Semantic UI extension for Yii2. It encapsulates Semantic UI components and plugins in terms of Yii widgets 
and helper classes, easing the usage of Semantic UI components/plugins into Yii applications.

## Install

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require --prefer-dist "2amigos/yii2-semantic-ui": "*"
```

or add

```json
"2amigos/yii2-semantic-ui": "*"
```

to the require section of your `composer.json` file. 

## Usage

We are in the process of building a site for this extensions in the meantime, for example, making use of the `Dropdown` 
module widget with a search-in menu feature is as follows:

``` php
echo Dropdown::widget([
    'encodeText' => false,
    'text' => '<i class="filter icon"></i><span class="text">Filter posts</span>',
    'icon' => false,
    'displaySearchInput' => true,
    'encodeItemLabels' => false,
    'items' => [
        '<div class="header"><i class="tags icon"></i>Tag Label</div>',
        ['label' => '<div class="ui red empty circular label"></div>Important'],
        ['label' => '<div class="ui blue empty circular label"></div>Announcement']
    ],
    'options' => [
        'class' => 'floating labeled search icon button'
    ],
]
);
```

## Testing  

To test the extension, is better to clone this repository on your computer. After, go to the extensions folder and do
the following (assuming you have `composer` installed on your computer: 

``` bash 
$ composer install --no-interaction --prefer-source --dev
```
Once all required libraries are installed then do: 

```bash 
$ phpunit
```

You can also run tests for specific groups only: 

```bash 
$ phpunit --group=helpers,modules
``` 
You can get a list of available groups via `phpunit --list-groups`.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Antonio Ramirez](https://github.com/tonydspaniard)
- [All Contributors](../../contributors)

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.

> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)  
<i>web development has never been so fun</i>  
[www.2amigos.us](http://www.2amigos.us)
