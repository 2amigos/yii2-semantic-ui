<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\modules;

use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Rating generates a rating semantic ui module
 *
 * For example
 *
 * ```php
 * echo Rating::widget([
 *  'rating' => 2,
 *  'options' => ['class' => 'star']
 * ]);
 * ```
 *
 * @see http://semantic-ui.com/modules/rating.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Rating extends Widget
{
    const SIZE_MINI = 'mini';
    const SIZE_TINY = 'tiny';
    const SIZE_SMALL = 'small';
    const SIZE_DEFAULT = '';
    const SIZE_LARGE = 'large';
    const SIZE_HUGE = 'huge';
    const SIZE_MASSIVE = 'massive';

    /**
     * @var int maximum rating number. Defaults to 5.
     */
    public $max = 5;
    /**
     * @var int the current rating value.
     */
    public $rating;
    /**
     * @var string the size of the rating. Can be [[SIZE_MINI]], [[SIZE_TINY]], [[SIZE_SMALL]], [[SIZE_DEFAULT]],
     * [[SIZE_LARGE], [[SIZE_HUGE]], and [[SIZE_MASSIVE]] or empty for default.
     */
    public $size = self::SIZE_DEFAULT;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->max <= 0) {
            throw new InvalidConfigException("Max rating number cannot be less or equal to 0.");
        }
        if ($this->rating !== null) {
            if ($this->rating > $this->max) {
                throw new InvalidConfigException("Rating number cannot be higher than Max rating number.");
            }
            $this->options['data-rating'] = $this->rating;
        }
        $this->options['data-max-rating'] = $this->max;
        if (!empty($this->size)) {
            Html::addCssClass($this->options, $this->size);
        }
        Html::addCssClass($this->options, 'rating');
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::tag('div', '', $this->options);
        $this->registerPlugin('rating');
    }
}
