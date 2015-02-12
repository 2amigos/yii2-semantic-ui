<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace dosamigos\semantic\helpers;

use dosamigos\semantic\modules\Checkbox;
use dosamigos\semantic\modules\Radio;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Yii;

/**
 * Ui overrides the static methods provided by [[yii\helpers\Html]] to adapt its tags to semantic ui styles.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\helpers
 */
class Ui extends Html
{
    /**
     * @inheritdoc
     */
    public static function beginForm($action = '', $method = 'post', $options = [])
    {
        static::addCssClasses($options, ['ui', 'form']);
        return parent::beginForm($action, $method, $options);
    }

    /**
     * @inheritdoc
     */
    public static function img($src, $options = [])
    {
        static::addCssClasses($options, ['ui', 'image']);
        return parent::img($src, $options);
    }

    /**
     * @inheritdoc
     */
    public static function button($content = 'Button', $options = [])
    {
        static::addCssClasses($options, ['ui', 'button']);
        return parent::button($content, $options);
    }

    /**
     * @inheritdoc
     */
    public static function buttonInput($label = 'Button', $options = [])
    {
        static::addCssClasses($options, ['ui', 'button']);
        return parent::buttonInput($label, $options);
    }

    /**
     * @inheritdoc
     */
    public static function submitInput($label = 'Submit', $options = [])
    {
        static::addCssClasses($options, ['ui', 'button']);
        return parent::submitInput($label, $options);
    }

    /**
     * @inheritdoc
     */
    public static function resetInput($label = 'Reset', $options = [])
    {
        static::addCssClasses($options, ['ui', 'button']);
        return parent::resetInput($label, $options);
    }

    /**
     * @inheritdoc
     */
    public static function checkbox($name, $checked = false, $options = [])
    {
        return Checkbox::widget(
            [
                'label' => ArrayHelper::getValue($options, 'label', false),
                'checked' => $checked,
                'name' => $name,
                'value' => ArrayHelper::getValue($options, 'value', '1'),
                'options' => $options
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function checkboxList($name, $selection = null, $items = [], $options = [])
    {
        $options['item'] = function ($index, $label, $name, $checked, $value) {
            return Checkbox::widget(
                ['label' => $label, 'checked' => $checked, 'name' => $name, 'value' => $value]
            );
        };

        static::addCssClasses($options, ['grouped', 'fields']);
        return Html::checkboxList($name, $selection, $items, $options);
    }

    /**
     * @inheritdoc
     */
    public static function radio($name, $checked = false, $options = [])
    {
        return Radio::widget(
            [
                'label' => ArrayHelper::getValue($options, 'label', false),
                'checked' => $checked,
                'name' => $name,
                'value' => ArrayHelper::getValue($options, 'value', '1'),
                'options' => $options
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function radioList($name, $selection = null, $items = [], $options = [])
    {
        $options['item'] = function ($index, $label, $name, $checked, $value) {
            return Radio::widget(
                ['label' => $label, 'checked' => $checked, 'name' => $name, 'value' => $value]
            );
        };

        static::addCssClasses($options, ['grouped', 'fields']);
        return Html::radioList($name, $selection, $items, $options);
    }

    /**
     * @inheritdoc
     */
    public static function dropDownList($name, $selection = null, $items = [], $options = [])
    {
        static::addCssClasses($options, ['ui', 'dropdown']);
        return parent::dropDownList($name, $selection, $items, $options);
    }

    /**
     * @inheritdoc
     */
    public static function listBox($name, $selection = null, $items = [], $options = []) {
        static::addCssClasses($options, ['ui', 'dropdown']);
        return parent::listBox($name, $selection, $items, $options);
    }


    /**
     * @inheritdoc
     */
    public static function error($model, $attribute, $options = [])
    {
        $options['tag'] = 'div';
        static::addCssClasses($options, ['ui', 'pointing', 'prompt', 'label', 'transition', 'visible']);
        return parent::error($model, $attribute, $options);
    }

    /**
     * @inheritdoc
     */
    public static function errorSummary($models, $options = [])
    {
        static::addCssClasses($options, ['ui', 'message']);

        return parent::errorSummary($models, $options);
    }

    /**
     * @inheritdoc
     */
    public static function activeRadio($model, $attribute, $options = [])
    {

        return Radio::widget(
            [
                'model' => $model,
                'attribute' => $attribute,
                'options' => $options
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function activeCheckbox($model, $attribute, $options = [])
    {

        return Checkbox::widget(
            [
                'model' => $model,
                'attribute' => $attribute,
                'options' => $options
            ]
        );
    }

    /**
     * Adds multiple CSS classes to the specified options.
     * If one of the CSS class is already in the options, it will not be added again.
     *
     * @param array $options the options to be modified.
     * @param array $classes the CSS classes to be added
     */
    public static function addCssClasses(&$options, $classes)
    {
        foreach ($classes as $class) {
            Html::addCssClass($options, $class);
        }
    }
}
