<?php
/**
 *
 * Radio.php
 *
 * Date: 22/01/15
 * Time: 11:32
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
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