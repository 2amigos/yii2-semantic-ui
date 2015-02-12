<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use dosamigos\semantic\InputWidget;
use yii\helpers\Html;

/**
 * Search generates a semantic ui search module
 * For example
 *
 * ```php
 *
 * // with local source
 * echo Search::widget([
 *  'name' => 'basic-test',
 *  'inputOptions' => ['placeholder' => 'Animals...'],
 *  'clientOptions' => [
 *      'type' => 'standard',
 *      'source' => [
 *          ['title' => 'Horse', 'description' => 'An Animal'],
 *          ['title' => 'Cow', 'description' => 'Another Animal']
 *      ],
 *      'searchFields' => ['title'],
 *      'searchFullText' => false
 *  ]
 * ]);
 *
 *
 * // with remote source
 * $uri = \yii\helpers\Url::to(['site/search']) . '&q={query}';
 * echo Search::widget([
 *  'name' => 'category-test',
 *  'type' => Search::TYPE_CATEGORY,
 *  'inputOptions' => ['placeholder' => 'Animals...'],
 *  'options' => [
 *      'class' => 'fluid'
 *  ],
 *  'clientOptions' => [
 *      'apiSettings' => [
 *          'action' => 'search',
 *          'url' => $uri
 *      ],
 *      'searchFullText' => false
 *  ]
 * ]);
 * ```
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
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
    /**
     * @var string the type of search. It could be of type 'category' or 'standard'
     */
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

    /**
     * Generates the search input
     *
     * @param array $options the tag options in terms of name-value pairs
     * @param array $resultsOptions the results layer options in terms of name-value pairs
     *
     * @return string the generated search input
     */
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
