<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use dosamigos\semantic\InputWidget;
use yii\helpers\Html;

class Search extends InputWidget
{
    const TYPE_STANDARD = 'standard';
    const TYPE_CATEGORY = 'category';

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputOptions = [];
    /**
     * @var bool whether to display the search icon or not.
     */
    public $displayIcon = true;
    /**
     * @var array the HTML attributes for the results dropdown.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $resultsOptions = [];
    public $type = self::TYPE_STANDARD;

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->resultsOptions, 'results');
        Html::addCssClass($this->options, 'search');
        if(!empty($this->type)) {
            Html::addCssClass($this->options, $this->type);
            $this->clientOptions['type'] = $this->type;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = $this->renderInput($this->inputOptions, $this->resultsOptions);
        echo Html::tag('div', $content, $this->options);
        $this->registerPlugin('search');
    }

    protected function renderInput($options = [], $resultsOptions = [])
    {
        Html::addCssClass($options, 'prompt');

        $lines = [];
        $input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $options)
            : Html::textInput($this->name, $this->value, $options);

        if (!empty($this->displayIcon)) {
            $lines[] = Html::beginTag('div', ['class' => 'ui icon input']);
            $lines[] = $input;
            $lines[] = Html::tag('i', '', ['class' => 'icon search']);
            $lines[] = Html::endTag('div');
        } else {
            $lines[] = $input;
        }
        $lines[] = Html::tag('div', '', $resultsOptions);
        return implode("\n", $lines);
    }
}