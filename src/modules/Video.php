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
 * Video renders a video module
 * For example
 *
 * ```php
 * echo Video::widget([
 *  'source' => 'youtube',
 *  'videoId' => 'i_mKY2CQ9Kk',
 *  'image' => 'http://semantic-ui.com/images/cat.jpg'
 * ]);
 *
 * ```
 *
 * @see http://semantic-ui.com/modules/video.html
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\modules
 */
class Video extends Widget
{
    const SOURCE_YOUTUBE = 'youtube';
    const SOURCE_VIMEO = 'vimeo';

    /**
     * @var string whats the image to display for the presentation of the video
     */
    public $image;
    /**
     * @var string whats the source. It can be whether "youtube" or "vimeo"
     */
    public $source;
    /**
     * @var string the video id. Its required if no video $url has been defined.
     */
    public $videoId;
    /**
     * @var string the video url. Its required if no $videoId has been defined.
     */
    public $url;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->image === null) {
            throw new InvalidConfigException('"image" cannot be null.');
        }
        if ($this->source === null) {
            throw new InvalidConfigException('"source" cannot be null.');
        }
        if ($this->videoId === null && $this->url === null) {
            throw new InvalidConfigException('"videoId" or "url" must be set. Both cannot be null.');
        }
        $this->clientOptions['source'] = $this->source;
        $this->clientOptions['id'] = $this->videoId;
        $this->clientOptions['url'] = $this->url;

        Html::addCssClass($this->options, 'video');
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = array_filter(
            [
                'data-image' => $this->image
            ]
        );

        echo Html::tag('div', '', array_merge($this->options, $options));
        $this->registerPlugin('video');
    }
}
