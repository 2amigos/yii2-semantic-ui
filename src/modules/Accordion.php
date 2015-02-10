<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;

use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Accordion renders an accordion semantic ui module.
 *
 * For example:
 *
 * ```php
 * echo Accordion::widget([
 *      'items' => [
 *          [
 *              'label' => 'Clothing',
 *              'active' => true,
 *              'content' => 'This is the content for clothing'
 *          ],
 *          [
 *              'label' => 'Status',
 *              'content' => 'This is the content for status'
 *          ],
 *      ],
 *  ]);
 * ```
 *
 * @see http://semantic-ui.com/modules/accordion.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Accordion extends Widget
{
    /**
     * @var array list of groups in the collapse widget. Each array element represents a single
     * group with the following structure:
     *
     * - label: string, required, the group header label.
     * - active: boolean, optional, whether this item should be active
     * - encode: boolean, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - content: string, required, the content (HTML) of the group
     * - options: array, optional, the HTML attributes of the group
     * - contentOptions: optional, the HTML attributes of the group's content
     *
     * ```
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'accordion');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderItems() . "\n";
        echo Html::endTag('div') . "\n";
        $this->registerPlugin('accordion');
    }

    /**
     * Renders collapsible items as specified on [[items]].
     * @throws InvalidConfigException if label isn't specified
     * @return string the rendering result
     */
    public function renderItems()
    {
        $items = [];
        $index = 0;
        foreach ($this->items as $item) {
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $items[] = $this->renderItem($item, ++$index);
        }
        return implode("\n", $items);
    }

    /**
     * Renders a single collapsible item group
     *
     * @param array $item a single item from [[items]]
     * @param integer $index the item index as each item group content must have an id
     *
     * @return string the rendering result
     * @throws InvalidConfigException
     */
    public function renderItem($item, $index)
    {
        if (array_key_exists('content', $item)) {
            $label = ArrayHelper::getValue($item, 'label');
            $options = ArrayHelper::getValue($item, 'options', []);
            $options['id'] = $this->options['id'] . '-accordion' . $index;
            $contentOptions = ArrayHelper::getValue($item, 'contentOptions', []);

            if (ArrayHelper::getValue($item, 'active')) {
                Html::addCssClass($options, 'active');
                Html::addCssClass($contentOptions, 'active');
            }

            Html::addCssClass($options, 'title');
            Html::addCssClass($contentOptions, 'content');

            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            if ($encodeLabel) {
                $label = Html::encode($label);
            }
            $title = Html::tag('i', '', ['class' => 'dropdown icon']) . $label;
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }
        $group = [];
        $group[] = Html::tag('div', $title, $options) . "\n";
        $group[] = Html::tag('div', $item['content'], $contentOptions) . "\n";
        return implode("\n", $group);
    }
}