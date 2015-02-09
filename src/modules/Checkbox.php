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

class Checkbox extends InputWidget
{
    public $label;
    public $encodeLabel = true;
    public $checked = false;
    public $labelOptions = [];
    public $wrapperOptions = [];

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

    protected function renderInput()
    {
        return $this->hasModel()
            ? Html::activeCheckbox($this->model, $this->attribute, $this->options)
            : Html::checkbox($this->name, $this->checked, $this->options);
    }

    protected function renderLabel()
    {
        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;
        return $this->hasModel()
            ? Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
            : Html::label($label, $this->getId(), $this->labelOptions);
    }
}