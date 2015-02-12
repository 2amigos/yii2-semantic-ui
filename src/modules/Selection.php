<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;


use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use Yii;

/**
 * Selection generates a semantic ui selection list
 * For example
 *
 * ```php
 * echo Selection::widget([
 *  'name' => 'test-selection',
 *  'items' => [
 *      'value1' => [ 'label' => 'Value 1' ],
 *      'value2' => [ 'label' => 'Value 2' ]
 *  ]
 * ]);
 * ```
 *
 * @see http://semantic-ui.com/collections/form.html#selection-dropdown
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Selection extends InputWidget
{
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeItemLabels = true;
    /**
     * @var boolean whether the text of the dropdown should be HTML-encoded
     */
    public $encodeDefaultText = true;
    /**
     * @var string the default text to display
     */
    public $defaultText;
    /**
     * @var array the selection data items. The array keys are option values, and the array values
     * are the corresponding option labels.
     */
    public $items = [];
    /**
     * @var string|array upload route
     */
    public $url;
    /**
     * @var array the plugin options. For more information see the jQuery File Upload options documentation.
     * @see https://github.com/blueimp/jQuery-File-Upload/wiki/Options
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the jQuery File Upload plugin.
     * Please refer to the jQuery File Upload plugin web page for possible options.
     * @see https://github.com/blueimp/jQuery-File-Upload/wiki/Options#callback-options
     */
    public $clientEvents = [];

    /**
     * Initializes the widget.
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        foreach ($this->items as $value => $item) {
            if (is_string($item)) {
                throw new InvalidConfigException("Items cannot be of type string.");
            }
            $item['options'] = ['value' => $value];
        }
        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
            if (!empty($value)) {
                $defaultText = $value;
            }
        } else {
            if (!empty($this->value)) {
                $defaultText = $this->value;
            }
        }
        if (empty($defaultText)) {
            $defaultText = Yii::t('dosamigos/semantic/selection', 'Select...');
        }
        $this->defaultText = $this->encodeDefaultText ? Html::encode($defaultText) : $defaultText;
        Html::addCssClass($this->options, 'selection');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $input = $this->hasModel()
            ? Html::activeHiddenInput($this->model, $this->attribute)
            : Html::hiddenInput($this->name, $this->value);

        $defaultText = $this->defaultText
            ? Html::tag('div', $this->defaultText, ['class' => 'default text'])
            : '';

        echo Dropdown::widget(
            [
                'id' => $this->getId(),
                'encodeText' => false,
                'encodeItemLabels' => $this->encodeItemLabels,
                'text' => $input . $defaultText,
                'items' => $this->items,
                'options' => $this->options,
                'clientOptions' => $this->clientOptions,
                'clientEvents' => $this->clientEvents
            ]
        );
    }
} 
