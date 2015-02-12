<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace dosamigos\semantic\collections;

use dosamigos\semantic\DosAmigosAsset;
use dosamigos\semantic\helpers\Ui;
use dosamigos\semantic\helpers\Element;
use dosamigos\semantic\Widget;
use yii\helpers\ArrayHelper;

/**
 * Message renders a Semantic UI message
 *
 * @see http://semantic-ui.com/collections/message.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\collections
 */
class Message extends Widget
{
    /**
     * @var string the icon to render with the message box. Semantic-ui provides a style for rendering icons. Check
     * [the documentation](http://semantic-ui.com/collections/message.html) for further references.
     *
     * Note: This attribute expects the full HTML of the icon. See [[Ui::icon]].
     */
    public $icon;
    /**
     * @var array the options for rendering the header tag.
     * The header tag is displayed within the content tag and is specified here to ease the task. If false or empty, it
     * won't be rendered.
     *
     * The following special options are supported:
     *
     * - label: string, the header text.
     * - options: array, the HTML attributes of the header.
     *
     */
    public $header = [];
    /**
     * @var string the body content in the alert component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the Alert widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;
    /**
     * @var array the HTML options for rendering the close icon.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     */
    public $closeIcon = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initOptions();

        echo Ui::beginTag('div', $this->options) . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . Ui::endTag('div');

        $this->registerClientScript();
    }

    /**
     * Renders the close button and its header (if any)
     *
     * @return string the begin of the body
     */
    public function renderBodyBegin()
    {
        $lines[] = $this->renderCloseButton();
        if ($this->icon !== null) {
            $lines[] = $this->icon;
        }
        $lines[] = $this->renderHeader();

        return implode("\n", $lines);
    }

    /**
     * Renders the body (if any) and the final closing tags of the message
     * @return string the end of the message's body
     */
    public function renderBodyEnd()
    {
        $lines[] = $this->body;
        if ($this->header !== false || !empty($this->header)) {
            $lines[] = Ui::endTag('div');
        }
        return implode("\n", $lines);
    }

    /**
     * Initializes the message closing buttons
     */
    public function registerClientScript()
    {
        if ($this->closeIcon !== false) {
            $view = $this->getView();
            DosAmigosAsset::register($view);
            $view->registerJs("dosamigos.semantic.initMessageCloseButtons();");
        }
    }

    /**
     * Renders the close button
     *
     * @return string the rendering result
     */
    public function renderCloseButton()
    {
        return $this->closeIcon !== false ? Element::icon('close') : null;
    }

    /**
     * Renders the icon of the message box (if any)
     *
     * @return string the icon
     */
    public function renderIcon()
    {
        return $this->icon;
    }

    /**
     * Renders the header (if any)
     *
     * @return null|string
     */
    public function renderHeader()
    {
        if ($this->header !== false || !empty($this->header)) {
            $content = ArrayHelper::getValue($this->header, 'label', '');
            $options = ArrayHelper::getValue($this->header, 'options', ['class' => 'header']);
            $header = Ui::tag('div', $content, $options);
            $lines[] = Ui::beginTag('div', ['class' => 'content']);
            $lines[] = $header;
            return implode("\n", $lines);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options
     */
    public function initOptions()
    {
        Ui::addCssClasses($this->options, ['ui', 'message']);
        if (!empty($this->header) && isset($this->header['options'])) {
            Ui::addCssClass($this->header['options'], 'header');
        }
        if (isset($this->icon)) {
            Ui::addCssClass($this->options, 'icon');
        }
    }

}
