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

class SideBar extends Menu
{
    const POS_TOP = 'top';
    const POS_BOTTOM = 'bottom';
    const POS_LEFT = 'left';
    const POS_RIGHT = 'right';
    const POS_DEFAULT = '';

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

    public function init()
    {
        Html::addCssClass($this->options, $this->position);
        Html::addCssClass($this->options, 'sidebar');
        Html::addCssClass($this->options, 'vertical');
        parent::init();
    }

    public function run()
    {
        parent::run();
        echo $this->renderToggleButton();
        $this->registerPlugin('sidebar');
    }

    public function renderToggleButton()
    {
        if($this->toggleButton !== false) {
            $tag = ArrayHelper::remove($this->toggleButton, 'tag', 'div');
            $label = ArrayHelper::remove($this->toggleButton, 'label', Html::tag('i','', ['class' =>'content icon']));

            Html::addCssClass($this->toggleButton, 'ui');
            Html::addCssClass($this->toggleButton, 'launch-sidebar icon');
            Html::addCssClass($this->toggleButton, 'button');
            Html::addCssClass($this->toggleButton, 'fixed');
            Html::addCssClass($this->toggleButton, 'attached');
            if($this->position === static::POS_LEFT) {
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