<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;

use dosamigos\semantic\helpers\Ui;
use dosamigos\semantic\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Checkbox renders a semantic ui checkbox
 *
 * For example:
 *
 * ```php
 * echo Checkbox::widget([
 *  'label' => 'Make my profile visible',
 *  'name' => 'terms',
 *  'options' => [
 *      'class' => 'slider'
 *  ]
 * ]);
 *
 * ```
 *
 * @see http://semantic-ui.com/modules/checkbox.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Checkbox extends InputWidget
{
    /**
     * @var string the checkbox label
     */
    public $label;
    /**
     * @var bool whether to encode the label or not. Defaults to true.
     */
    public $encodeLabel = true;
    /**
     * @var bool whether to display the checkbox on its "checked" state.
     */
    public $checked = false;
    /**
     * @var array the label tag HTML attributes as name-value pairs.
     */
    public $labelOptions = [];
    /**
     * @var array the wrapper tag HTML attributes as name-value pairs.
     */
    public $wrapperOptions = [];

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->label === null) {
            $this->label = $this->hasModel()
                ? $this->model->getAttributeLabel($this->attribute)
                : ArrayHelper::getValue($this->options, 'label', false);
        }
        Html::removeCssClass($this->options, 'ui');
        Ui::addCssClasses($this->wrapperOptions, ['ui', 'checkbox']);
        $this->wrapperOptions['id'] = $this->options['id'] . '-wrapper';
        $this->selector = $this->selector ?: '#' . $this->wrapperOptions['id'];
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $lines = [];
        $lines[] = $this->renderInput();

        if ($this->label !== false) {
            $lines[] = $this->renderLabel();
        }

        echo Html::tag('div', implode("\n", $lines), $this->wrapperOptions);
        $this->registerPlugin('checkbox');
    }

    /**
     * Renders the checkbox input
     *
     * @return string the generated checkbox input
     */
    protected function renderInput()
    {
        return $this->hasModel()
            ? Html::activeCheckbox($this->model, $this->attribute, $this->options)
            : Html::checkbox($this->name, $this->checked, $this->options);
    }

    /**
     * Renders checkbox label
     *
     * @return string the generated label
     */
    protected function renderLabel()
    {
        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;
        return $this->hasModel()
            ? Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
            : Html::label($label, $this->getId(), $this->labelOptions);
    }
}