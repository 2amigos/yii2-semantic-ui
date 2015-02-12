<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace dosamigos\semantic\collections;

use Yii;
use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Breadcrumbs generates a Semantic UI breadcrumb collection
 *
 * For example:
 *
 * ```php
 * echo Breadcrumbs::widget([
 *  'links' => [
 *      [
 *          'label' => 'Step 1',
 *          'class' => 'mycustomclass',
 *          'url' => '#'
 *      ],
 *      [
 *          'label' => 'Step 2',
 *          'class' => 'mycustomclass'
 *      ],
 *  ]
 * ]);
 *
 * ```
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\collections
 */
class Breadcrumbs extends Widget
{
    /**
     * @var array the first hyperlink in the breadcrumbs (called home link).
     * Please refer to [[links]] on the format of the link.
     * If this property is not set, it will default to a link pointing to [[\yii\web\Application::homeUrl]]
     * with the label 'Home'. If this property is false, the home link will not be rendered.
     */
    public $homeLink;
    /**
     * @var array list of links to appear in the breadcrumbs. If this property is empty,
     * the widget will not render anything. Each array element represents a single link in the breadcrumbs
     * with the following structure:
     *
     * ```php
     * [
     *     'label' => 'label of the link',  // required
     *     'url' => 'url of the link',      // optional, will be processed by Url::to()
     *     'template' => 'own template of the item', // optional, if not set $this->itemTemplate will be used
     * ]
     * ```
     *
     * If a link is active, you only need to specify its "label", and instead of writing `['label' => $label]`,
     * you may simply use `$label`.
     *
     * Any additional array elements for each link will be treated as the HTML attributes
     * for the hyperlink tag. For example, the following link specification will generate a hyperlink
     * with CSS class `external`:
     *
     * ```php
     * [
     *     'label' => 'demo',
     *     'url' => 'http://example.com',
     *     'class' => 'external',
     * ]
     * ```
     *
     */
    public $links = [];
    /**
     * @var bool whether to encode labels or not
     */
    public $encodeLabels = true;
    /**
     * @var string the HTML element to be used as breadcrumb divider
     */
    public $divider = "<div class='divider'> / </div>";
    /**
     * @var string the template used to render each inactive item in the breadcrumbs. The tokens `{url}` and `{label}`
     * will be replaced with the actual HTML link for each inactive item.
     */
    protected $itemTemplate = "{link}\n";
    /**
     * @var string the template used to render each active item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each active item.
     */
    protected $activeItemTemplate = "<div class='active section'>{link}</div>\n";

    /**
     * @ineritdoc
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'breadcrumb');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem(
                [
                    'label' => Yii::t('dosamigos/semantic/breadcrumbs', 'Home'),
                    'url' => Yii::$app->homeUrl,
                ],
                $this->itemTemplate
            );
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag('div', implode($this->divider, $links), $this->options);
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the link.
     *
     * @return string the rendering result
     * @throws InvalidConfigException if `$link` does not have "label" element.
     */
    protected function renderItem($link, $template)
    {
        if (array_key_exists('label', $link)) {
            $label = $this->encodeLabels ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }
        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            Html::addCssClass($options, 'section');
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }
        return strtr($template, ['{link}' => $link]);
    }
}
