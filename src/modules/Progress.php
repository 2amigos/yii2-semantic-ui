<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;

use dosamigos\semantic\Widget;
use yii\helpers\Html;

/**
 * Progress renders a progress semantic ui module
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Progress extends Widget
{

    const SIZE_TINY = 'tiny';
    const SIZE_SMALL = 'small';
    const SIZE_DEFAULT = '';
    const SIZE_LARGE = 'large';
    const SIZE_BIG = 'big';

    /**
     * @var string the size of the rating. Can be [[SIZE_TINY]], [[SIZE_SMALL]], [[SIZE_DEFAULT]],
     * [[SIZE_LARGE], and [[SIZE_BIG]] or empty for default.
     */
    public $size = self::SIZE_DEFAULT;
    /**
     * @var string the progress label.
     */
    public $label;
    /**
     * @var bool whether to encode the label or not.
     */
    public $encodeLabel = true;
    /**
     * @var integer the amount of progress as a percentage. Set to null if you don't wish to display the percent number.
     */
    public $percent;
    /**
     * @var bool whether to display the percentage amount inside the bar or not
     */
    public $showPercent = true;
    /**
     * @var array the HTML attributes of the bar.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $barOptions = [];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        if ($this->percent !== null) {
            $this->clientOptions['percent'] = $this->percent;
        }
        if (!empty($this->size)) {
            Html::addCssClass($this->options, $this->size);
        }
        Html::addCssClass($this->barOptions, 'bar');
        Html::addCssClass($this->options, 'progress');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderBar($this->label) . "\n";
        echo Html::endTag('div') . "\n";
        $this->registerPlugin('progress');
    }

    /**
     * Generates a bar
     *
     * @param string $label , optional, the label to display at the bar
     *
     * @return string the rendering result.
     */
    protected function renderBar($label = null)
    {

        $lines = [];
        $content = $this->showPercent ? Html::tag('div', '', ['class' => 'progress']) : '';
        $lines[] = Html::tag('div', $content, $this->barOptions);
        if ($this->label) {
            $label = $this->encodeLabel ? Html::encode($label) : $label;
            $lines[] = Html::tag('div', $label, ['class' => 'label']);
        }
        return implode("\n", $lines);
    }
}
