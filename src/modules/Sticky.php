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

/**
 * Sticky Generates a semantic ui sticky module
 * For example
 *
 * ```php
 * echo Sticky::widget([
 *  'context' => '#examples',
 *  'content' => 'Hello, I am sticky',
 *  'clientOptions' => [
 *      'offset' => 50,
 *      'bottomOffset' => 50
 *  ]
 * ]);
 *
 * ```
 *
 * @see http://semantic-ui.com/modules/sticky.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Sticky extends Widget
{
    /**
     * @var string the jQuery element id to stick to
     */
    public $context;
    /**
     * @var string the content of the sticky
     */
    public $content;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
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

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options);
        echo Html::tag('div', $this->content, ['class' => 'ui sticky']);
        echo Html::endTag('div');
        $this->registerPlugin('sticky');
    }
}
