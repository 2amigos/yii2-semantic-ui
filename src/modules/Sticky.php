<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class Sticky extends Widget
{
    public $context;
    public $content;
    public function init()
    {
        parent::init();
        if($this->context === null) {
            throw new InvalidConfigException('"context" cannot be null.');
        }
        if($this->content === null) {
            throw new InvalidConfigException('"content" cannot be null.');
        }
        $this->clientOptions['context'] = $this->context;
        $this->selector = '.ui.sticky';
        Html::addCssClass($this->options, 'rail');
    }

    public function run()
    {
        echo Html::beginTag('div', $this->options);
        echo Html::tag('div', $this->content, ['class' => 'ui sticky']);
        echo Html::endTag('div');
        $this->registerPlugin('sticky');
    }
}