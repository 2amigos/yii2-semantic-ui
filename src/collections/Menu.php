<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace dosamigos\semantic\collections;

use dosamigos\semantic\modules\Dropdown;
use Yii;
use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Menu renders a Menu collection.
 *
 * For example
 *
 * ```php
 * echo Menu::widget([
 *  'items' => [
 *      Html::tag('div', 'Cat University', ['class' => 'header item']),
 *      [ 'label' => 'Menu A', 'url' => ['/menu-a']],
 *      [ 'label' => 'Menu B', 'url' => ['/menu-b']],
 *      [ 'label' => 'Only label'],
 *      [
 *          'label' => 'Menu C',
 *          'options' => [ 'class' => 'right' ],
 *          'items' => [
 *              [ 'label' => 'Menu C-A', 'url' => ['/menu-ca']],
 *              [ 'label' => 'Menu C-B', 'url' => ['/menu-cb']],
 *              [ 'label' => 'Only label' ],
 *          ]
 *      ],
 *  ]
 * ]);
 * ```
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\collections
 */
class Menu extends Widget
{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container.
     * - active: boolean, optional, whether the item should be on active state or not.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
     */
    public $encodeLabels = true;
    /**
     * @var boolean whether to automatically activate items according to whether their route setting
     * matches the currently requested route.
     * @see isItemActive
     */
    public $activateItems = true;
    /**
     * @var boolean whether to activate parent menu items when one of the corresponding child menu items is active.
     */
    public $activateParents = false;
    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @see params
     * @see isItemActive
     */
    public $route;
    /**
     * @var array the parameters used to determine if a menu item is active or not.
     * If not set, it will use `$_GET`.
     * @see route
     * @see isItemActive
     */
    public $params;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        Html::addCssClass($this->options, 'menu');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options);
        echo $this->renderItems($this->items);
        echo Html::endTag('div');
    }

    /**
     * Renders widget items.
     *
     * @param array $menuItems
     *
     * @return string
     * @throws InvalidConfigException
     */
    public function renderItems($menuItems)
    {
        $items = [];
        foreach ($menuItems as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            $items[] = $this->renderItem($item);
        }
        return implode("\n", $items);
    }

    /**
     * Renders a widget's item.
     *
     * @param string|array $item the item to render.
     *
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $options = ArrayHelper::getValue($item, 'options', []);

        $label = $this->getLabel($item);
        $url = ArrayHelper::getValue($item, 'url', '#');

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }
        Html::addCssClass($options, 'item');

        $items = ArrayHelper::getValue($item, 'items');
        if ($items !== null) {
            return Dropdown::widget(
                [
                    'encodeText' => false,
                    'text' => $label,
                    'items' => $items,
                    'options' => $options
                ]
            );
        } else {
            return Html::a($label, $url, $options);
        }
    }

    /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     *
     * @param array $items the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     *
     * @return string the rendering result.
     */
    protected function renderMenu($items, $parentItem)
    {
        $options = ArrayHelper::getValue($parentItem, 'options');
        $label = $this->getLabel($parentItem);
        $items = Html::tag('div', $this->renderItems($items), ['class' => 'menu']);
        Html::addCssClass($options, 'ui');
        Html::addCssClass($options, 'header');
        return
            Html::tag(
                'div',
                Html::tag('div', $label, $options) . $items,
                ['class' => 'item']
            );
    }

    /**
     * Returns the label
     *
     * @param array $item the item configuration
     *
     * @return string the label
     */
    protected function getLabel($item)
    {
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        return $encodeLabel ? Html::encode($item['label']) : $item['label'];
    }

    /**
     * Check to see if a child item is active optionally activating the parent.
     *
     * @param array $items @see items
     * @param boolean $active should the parent be active too
     *
     * @return array @see items
     */
    protected function isChildActive($items, &$active)
    {
        foreach ($items as $i => $child) {
            if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child)) {
                Html::addCssClass($items[$i]['options'], 'active');
                if ($this->activateParents) {
                    $active = true;
                }
            }
        }
        return $items;
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     *
     * @param array $item the menu item to be checked
     *
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
