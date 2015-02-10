<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Shape extends Widget
{

    /**
     * @var array list of menu items in the shape. Each array element is an array representing a single side with the
     * following structure:
     *
     * - content: string, required, the HTML content of the side
     * - options: array, optional, the HTML attributes of the side item.
     */
    public $sides = [];
    /**
     * @var array the HTML attributes for the widget sides items container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $sidesOptions = [];

    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'shape');
        Html::addCssClass($this->sidesOptions, 'sides');
    }

    public function run()
    {
        $lines = [];
        $lines[] = Html::beginTag('div', '', $this->options);
        $lines[] = $this->renderSides($this->sides);
        $lines[] = Html::endTag('div');

        echo implode("\n", $lines);
        $this->registerPlugin('shape');
    }

    protected function renderSides($sides)
    {
        $lines = [];
        $lines[] = Html::beginTag('div', '', $this->sidesOptions);
        foreach($sides as $side) {
            if(!array_key_exists('content', $side)) {
                throw new InvalidConfigException("The 'content' option is required per sides");
            }
            $lines[] = Html::tag('div', $side['content'], ArrayHelper::getValue($side, 'options', []));

        }
        $lines[] = Html::endTag('div');

        return implode("\n", $lines);
    }

}