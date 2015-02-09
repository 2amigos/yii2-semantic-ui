<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace dosamigos\semantic;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Widget is the base class for all semantic ui widgets.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic
 */
class Widget extends \yii\base\Widget
{
    /**
     * @var string whether to use a custom selector instead of the id of the widget.
     */
    public $selector;
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array the options for the underlying Semantic UI JS plugin.
     * Please refer to the corresponding Semantic UI plugin Web page for possible options.
     * For example, [this page](http://semantic-ui.com/modules/modal.html#/settings) shows
     * how to use the "Modal" plugin and the supported options (e.g. "remote").
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the underlying Semantic UI JS plugin.
     * Please refer to the corresponding Semantic UI plugin Web page for possible events.
     * For example, [this page](http://semantic-ui.com/modules/modal.html#/examples) shows
     * how to use the "Modal" plugin and the supported events (e.g. "onShow").
     */
    public $clientEvents = [];

    /**
     * Initializes the widget.
     * This method will register the semantic ui asset bundle and the translations. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'ui');

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $this->registerTranslations();
    }

    /**
     * Registers the required translations of the widgets
     */
    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['dosamigos/semantic/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => dirname(__FILE__) . '/messages',
        ];
    }

    /**
     * Registers a specific Semantic UI plugin and the related events
     *
     * @param string $name the name of the Semantic UI plugin
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();
        SemanticUiPluginAsset::register($view);
        $selector = $this->selector ? : '#' . $this->options['id'];
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
            $js = "jQuery('$selector').$name($options);";
            $view->registerJs($js);
        }
        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $handler = $handler instanceof JsExpression ? $handler : new JsExpression($handler);
                $js[] = "jQuery('$selector').$name('setting', '$event', $handler);";
            }
            $view->registerJs(implode("\n", $js));
        }
    }
}