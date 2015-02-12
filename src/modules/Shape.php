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
use dosamigos\semantic\helpers\Ui;

/**
 * Shape generates a semantic ui shape module. A three dimensional object displayed on a two dimensional plane.
 *
 * For example
 *
 * ```php
 * echo Shape::widget([
 *  'sides' => [
 *      ['content' => 'This side starts visible', 'active' => true], // first visible step
 *      ['content' => 'This is another ONEEEE'],
 *      ['content' => 'And ANOTHEEEER!']
 *  ]
 * ]);
 *
 * ```
 *
 * @see http://semantic-ui.com/modules/shape.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Shape extends Widget
{

    /**
     * @var array list of menu items in the shape. Each array element is an array representing a single side with the
     * following structure:
     *
     * - content: string, required, the HTML content of the side
     * - active: boolean, optional, whether this side should be active or not
     * - options: array, optional, the HTML attributes of the side item.
     */
    public $sides = [];
    /**
     * @var array the HTML attributes for the widget sides items container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $sidesOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'shape');
        Html::addCssClass($this->sidesOptions, 'sides');
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function run()
    {
        $lines = [];
        $lines[] = Html::beginTag('div', '', $this->options);
        $lines[] = $this->renderSides($this->sides);
        $lines[] = Html::endTag('div');

        echo implode("\n", $lines);
        $this->registerPlugin('shape');
    }

    /**
     * Renders the configured sides
     *
     * @param array $sides @see $sides
     *
     * @return string the generated shape sides
     * @throws InvalidConfigException
     */
    protected function renderSides($sides)
    {
        $lines = [];
        $lines[] = Html::beginTag('div', $this->sidesOptions);
        foreach($sides as $side) {
            if(!array_key_exists('content', $side)) {
                throw new InvalidConfigException("The 'content' option is required per sides");
            }
            $options = ArrayHelper::getValue($side, 'options', []);
            Ui::addCssClass($options, 'side');
            $active = ArrayHelper::getValue($side, 'active', false);
            if($active === true) {
                Ui::addCssClass($options, 'active');
            }
            $lines[] = Html::tag('div', $side['content'], $options);

        }
        $lines[] = Html::endTag('div');

        return implode("\n", $lines);
    }

}
