<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic;

use yii\web\AssetBundle;

/**
 * SemanticUiPluginAsset registers the semantic ui js assets
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic
 */
class SemanticUiPluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/semantic-ui/dist';
    /**
     * @inheritdoc
     */
    public $js = [
        'semantic.js',
        'components/api.js'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'dosamigos\semantic\SemanticUiAsset',
    ];
} 