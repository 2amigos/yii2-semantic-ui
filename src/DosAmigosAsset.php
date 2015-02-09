<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic;

use yii\web\AssetBundle;

/**
 * DosAmigosAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic
 */
class DosAmigosAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/2amigos/yii2-semantic-ui/assets';
    /**
     * @inheritdoc
     */
    public $js = ['js/dosamigos-semantic.ui.js'];
    /**
     * @inheritdoc
     */
    public $css = ['css/dosamigos-semantic.ui.css'];
    /**
     * @inheritdoc
     */
    public $depends = [
        'dosamigos\semantic\SemanticUiPluginAsset'
    ];

}