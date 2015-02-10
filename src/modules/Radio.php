<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use yii\helpers\Html;

class Radio extends Checkbox
{
    public function init()
    {
        parent::init();
        Html::addCssClass($this->wrapperOptions, 'radio');
    }

    protected function renderInput()
    {
        return $this->hasModel()
            ? Html::activeRadio($this->model, $this->attribute, $this->options)
            : Html::radio($this->name, $this->checked, $this->options);
    }
}