<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use dosamigos\semantic\collections\Menu;
use dosamigos\semantic\DosAmigosAsset;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * SideBar renders a Semantic UI sidebar
 *
 * For example
 *
 * ```php
 * echo SideBar::widget([
 *  'position' => 'left',
 *  'toggleButton' => [
 *      'style' => 'top:54px'
 *  ],
 *  'options' => [
 *      // 'class' => 'icon'
 *  ],
 * 'items' => [
 *      [
 *          'label' => '<i class="block layout icon"></i>Topics',
 *          'encode' => false
 *      ],
 *      [
 *          'label' => 'Elements',
 *          'encode' => false,
 *          'items' => [
 *              [
 *                  'label' => '<i class="block layout icon"></i>Topics',
 *                  'encode' => false
 *              ],
 *              [
 *                  'label' => '<i class="block layout icon"></i>Topics',
 *                  'encode' => false
 *              ],
 *          ]
 *      ]
 *  ]
 * ]);
 *
 * ``
 *
 * @see http://semantic-ui.com/modules/sidebar.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class SideBar extends Menu
{
    const POS_TOP = 'top';
    const POS_BOTTOM = 'bottom';
    const POS_LEFT = 'left';
    const POS_RIGHT = 'right';
    const POS_DEFAULT = '';

    /**
     * @var string where to position the sidebar menu
     */
    public $position = self::POS_DEFAULT;
    /**
     * @var array the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     */
    public $toggleButton = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        Html::addCssClass($this->options, $this->position);
        Html::addCssClass($this->options, 'sidebar');
        Html::addCssClass($this->options, 'vertical');
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        echo $this->renderToggleButton();
        $this->registerPlugin('sidebar');
    }

    /**
     * Generates the toggle button. The one that 'on-click', shows the sidebar.
     *
     * @return null|string the generated toggle button
     */
    public function renderToggleButton()
    {
        if ($this->toggleButton !== false) {
            $tag = ArrayHelper::remove($this->toggleButton, 'tag', 'div');
            $label = ArrayHelper::remove($this->toggleButton, 'label', Html::tag('i', '', ['class' => 'content icon']));

            Html::addCssClass($this->toggleButton, 'ui');
            Html::addCssClass($this->toggleButton, 'launch-sidebar icon');
            Html::addCssClass($this->toggleButton, 'button');
            Html::addCssClass($this->toggleButton, 'fixed');
            Html::addCssClass($this->toggleButton, 'attached');
            if ($this->position === static::POS_LEFT) {
                $position = static::POS_RIGHT;
            } else {
                $position = static::POS_LEFT;
            }
            Html::addCssClass($this->toggleButton, $position);
            $view = $this->getView();
            DosAmigosAsset::register($view);
            $view->registerJs('dosamigos.semantic.init();');
            return Html::tag($tag, $label, $this->toggleButton);
        } else {
            return null;
        }
    }
}
