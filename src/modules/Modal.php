<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use dosamigos\semantic\DosAmigosAsset;
use dosamigos\semantic\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the modal window:
 *
 * ```php
 * Modal::begin([
 *     'header' => '<h2>Hello world</h2>',
 *     'toggleButton' => ['label' => 'click me'],
 * ]);
 *
 * echo 'Say hello...';
 *
 * Modal::end();
 * ```
 *
 * ```php
 * Modal::begin([
 *  'toggleButton' => ['label' => 'Show modal'],
 *  'size' => 'fullscreen',
 *  'type' => 'basic',
 *  'footer' => '<div class="ui black negative button">Nope</div>' +
 *             '<div class="ui positive right labeled icon button">Yep, that\'s me<i class="checkmark icon"></i></div>',
 *  'clientEvents' => [
 *      'onDeny' => 'function(){ console.log("denied");}'
 *  ]
 * ]);
 * ```
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Modal extends Widget
{

    const TYPE_BASIC = "basic";
    const TYPE_STANDARD = "";

    const SIZE_FULLSCREEN = "fullscreen";
    const SIZE_SMALL = "small";
    const SIZE_LARGE = "large";

    /**
     * @var string the header content in the modal window.
     */
    public $header;
    /**
     * @var string additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions;
    /**
     * @var string the footer content in the modal window.
     */
    public $footer;
    /**
     * @var string additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions;
    /**
     * @var string the modal size. Can be [[SIZE_LARGE]], [[SIZE_SMALL]], and [[SIZE_FULLSCREEN]]or empty for default.
     */
    public $size;
    /**
     * @var string the modal type. Can be [[TYPE_BASIC]],  and [[TYPE_STANDARD]] or empty for default.
     */
    public $type;
    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://semantic-ui.com/modules/modal.html)
     * for the supported HTML attributes.
     */
    public $closeButton = [];
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
     * Please refer to the [Modal plugin help](http://semantic-ui.com/modules/modal.html)
     * for the supported HTML attributes.
     */
    public $toggleButton = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->initOptions();
        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div');
        $this->registerPlugin('modal');
    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $button = $this->renderCloseButton();

        if ($this->header !== null) {
            Html::addCssClass($this->headerOptions, 'header');
            $this->header = Html::tag('div', "\n" . $this->header . "\n", $this->headerOptions);
        }

        if ($button !== null || $this->header !== null) {
            return $button . "\n" . $this->header;
        } else {
            return null;
        }

    }

    /**
     * Renders the opening tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        return Html::beginTag('div', ['class' => 'content']);
    }

    /**
     * Renders the closing tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return Html::endTag('div');
    }

    /**
     * Renders the HTML markup for the footer of the modal
     * @return string the rendering result
     */
    protected function renderFooter()
    {
        if ($this->footer !== null) {
            Html::addCssClass($this->footerOptions, 'actions');
            return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if ($this->toggleButton !== false) {
            $tag = ArrayHelper::remove($this->toggleButton, 'tag', 'div');
            $label = ArrayHelper::remove($this->toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($this->toggleButton['type'])) {
                $this->toggleButton['type'] = 'button';
            }
            if ($tag === 'div') {
                Html::addCssClass($this->toggleButton, 'ui');
                Html::addCssClass($this->toggleButton, 'button');
            }
            $view = $this->getView();
            DosAmigosAsset::register($view);
            $view->registerJs('dosamigos.semantic.init();');

            return Html::tag($tag, $label, $this->toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if ($this->closeButton !== false) {
            return Html::tag('i', '', $this->closeButton);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $this->options = array_merge(
            [
                'tabindex' => -1,
            ],
            $this->options
        );

        Html::addCssClass($this->options, 'modal');
        if ($this->size !== null) {
            Html::addCssClass($this->options, $this->size);
        }
        if ($this->type !== null) {
            Html::addCssClass($this->options, $this->type);
        }

        if ($this->closeButton !== false) {
            Html::addCssClass($this->closeButton, 'icon');
            Html::addCssClass($this->closeButton, 'close');
        }
        if ($this->toggleButton !== false && is_array($this->toggleButton)) {
            $this->toggleButton = array_merge(
                [
                    'data-toggle' => 'semantic-modal',
                ],
                $this->toggleButton
            );
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
    }
}
