<?php
/**
 *
 * Sticky.php
 *
 * Date: 20/12/14
 * Time: 22:38
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
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