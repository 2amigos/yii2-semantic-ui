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
 * Dropdown renders a semantic ui dropdown module
 *
 * For example:
 *
 * ```php
 * echo Dropdown::widget([
 *  'text' => 'Shop',
 *  'items' => [
 *      '<div class="header">Categories</div>',
 *      [
 *          'label' => 'Clothing'
 *      ],
 *      '<div class="divider"></div>',
 *      '<div class="header">Order</div>',
 *      [
 *          'label' => 'Status',
 *          'url' => '#'
 *      ],
 *  ],
 * ]);
 *
 * ```
 *
 * @see http://semantic-ui.com/modules/dropdown.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Dropdown extends Widget
{
    /**
     * @var array the HTML attributes for the widget menu items container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $itemsOptions = [];
    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [[Url::to()]].
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *
     * To insert divider use `<div class="divider"></div>`.
     * To insert a header use `<div class="header">Text</div>`
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeItemLabels = true;
    /**
     * @var boolean whether the text of the dropdown should be HTML-encoded
     */
    public $encodeText = true;
    /**
     * @var string the text that will be displayed as the dropdown title.
     */
    public $text;
    /**
     * @var string displays the dropdown caret icon. Set to false if you do not want to show a dropdown caret icon.
     */
    public $icon = '<i class="dropdown icon"></i>';
    /**
     * @var bool whether to display the search in dropdown input
     */
    public $displaySearchInput = false;
    /**
     * @var array the HTML attributes of the search input as name-value pairs.
     */
    public $searchInputOptions = [];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'dropdown');
        Html::addCssClass($this->itemsOptions, 'menu');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderDropdown();
        $this->registerPlugin('dropdown');
    }

    /**
     * Renders the dropdown
     *
     * @return string the generated dropdown module
     * @throws InvalidConfigException
     */
    protected function renderDropdown()
    {
        $lines = [];
        $lines[] = $this->encodeText ? Html::encode($this->text) : $this->text;
        if ($this->icon && is_string($this->icon)) {
            $lines[] = $this->icon;
        }
        $lines[] = $this->renderItems($this->items, $this->options, $this->displaySearchInput);
        return Html::tag('div', implode("\n", $lines), $this->options);
    }

    /**
     * Renders menu items.
     *
     * @param array $items the menu items to be rendered
     * @param array $options the container HTML attributes
     * @param bool $displaySearchInput whether to render the search input or not
     *
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items, $options = [], $displaySearchInput = false)
    {
        $lines = [];
        if($displaySearchInput) {
            $lines[] = $this->renderSearchInput();
        }
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeItemLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $linkOptions['tabindex'] = '-1';
            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    $content = $label;
                } else {
                    $content = Html::a($label, $url, $linkOptions);
                }
            } else {
                $submenuOptions = $options;
                unset($submenuOptions['id']);
                $label = $url === null ? $label : Html::a($label, $url, $linkOptions);
                Html::addCssClass($itemOptions, 'text');
                $content =
                    Html::tag('i', '', ['class' => 'dropdown icon']) .
                    Html::tag('span', $label, $itemOptions) .
                    $this->renderItems($item['items'], $submenuOptions);
            }
            Html::addCssClass($itemOptions, 'item');
            $lines[] = Html::tag('div', $content, $itemOptions);
        }

        return Html::tag('div', implode("\n", $lines), $this->itemsOptions);

    }

    /**
     * Renders the search input
     *
     * @return string the generated search input
     */
    protected function renderSearchInput()
    {
        $lines = [];
        $lines[] = Html::beginTag('div', ['class' =>'ui icon search input']);
        $lines[] = Html::tag('i', '', ['class' => 'search icon']);
        $lines[] = Html::input('text', $this->getId() . '-search', '', $this->searchInputOptions);
        $lines[] = Html::endTag('div');
        $lines[] = Html::tag('div', '', ['class' => 'divider']);
        return implode("\n", $lines);
    }
}