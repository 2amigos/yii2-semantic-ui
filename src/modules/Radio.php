<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;

use yii\helpers\Html;

/**
 * Radio generates a radio box semantic ui form element
 *
 * @see http://semantic-ui.com/collections/form.html#radio-box
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Radio extends Checkbox
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->wrapperOptions, 'radio');
    }

    /**
     * Generates the Radio input
     *
     * @return string the generated radio input tag
     */
    protected function renderInput()
    {
        return $this->hasModel()
            ? Html::activeRadio($this->model, $this->attribute, $this->options)
            : Html::radio($this->name, $this->checked, $this->options);
    }
}
