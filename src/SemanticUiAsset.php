<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic;

use yii\web\AssetBundle;

/**
 * SemanticUiAsset registers the semantic ui css assets
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic
 */
class SemanticUiAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/semantic-ui/dist';
    /**
     * @inheritdoc
     */
    public $css = [
        'semantic.css',
        'components/flag.css'
    ];
} 