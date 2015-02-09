<?php
/**
 *
 * Video.php
 *
 * Date: 20/12/14
 * Time: 23:11
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */

namespace dosamigos\semantic\modules;


use dosamigos\semantic\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class Video extends Widget
{
    const SOURCE_YOUTUBE = 'youtube';
    const SOURCE_VIMEO = 'vimeo';

    public $image;
    public $source;
    public $videoId;
    public $url;

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