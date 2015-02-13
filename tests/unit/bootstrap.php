<?php
 /**
 * 
 * bootstrap.php
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'test');
//require(__DIR__ . '/../vendor/autoload.php');
//require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
//Yii::setAlias('@tests', __DIR__);
//new \yii\console\Application([
//    'id' => 'testApp',
//    'basePath' => __DIR__,
//]);

error_reporting(-1);
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);
$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
Yii::setAlias('@tests', __DIR__);
require_once(__DIR__ . '/TestCase.php');
