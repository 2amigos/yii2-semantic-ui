<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Element provides a set of static methods for generating semantic ui elements HTML tags
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\semantic\helpers
 */
class Element
{

    /**
     * Generates a button tag. Differs from [[Ui::button]] on that it allows the creation of a button with different
     * tags
     *
     * @param string $content
     * @param array $options
     *
     * @return string the generated button
     */
    public static function button($content = 'Button', $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        Ui::addCssClasses($options, ['ui', 'button']);
        return strcasecmp($tag, 'button') === 0
            ? Html::button($content, $options)
            : Html::tag($tag, $content, $options);
    }

    /**
     * Generates an [icon button](http://semantic-ui.com/elements/button.html#icon)
     *
     * @param string $glyph the glyphicon name to be used -ie "cloud"
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     *
     * @return string the generated icon button tag
     */
    public static function iconButton($glyph, $options = [])
    {
        $iOptions = ArrayHelper::remove($options, 'icon', []);
        Ui::addCssClasses($options, ['icon']);
        return static::button(static::icon($glyph, $iOptions), $options);
    }

    /**
     * Generates an [animated button](http://semantic-ui.com/elements/button.html#animated)
     *
     * @param string $visible the initial and visible content of the button
     * @param string $hidden the hidden content of the button. It will be displayed when the button is "on hover" state.
     * @param array $options the tag options in terms of name-value pairs.
     *
     * @return string the generated animated button tag
     */
    public static function animatedButton($visible, $hidden, $options = [])
    {
        $hOptions = ArrayHelper::remove($options, 'hidden', []);
        $vOptions = ArrayHelper::remove($options, 'visible', []);
        Ui::addCssClasses($options, ['ui', 'animated', 'button']);
        Ui::addCssClasses($hOptions, ['hidden', 'content']);
        Ui::addCssClasses($vOptions, ['visible', 'content']);
        $lines = [];
        $lines[] = Html::tag('div', $hidden, $hOptions);
        $lines[] = Html::tag('div', $visible, $vOptions);

        return Html::tag('div', implode("\n", $lines), $options);

    }

    /**
     * Generates a [labeled icon button](http://semantic-ui.com/elements/button.html#labeled-icon)
     *
     * @param string $label the label of the button
     * @param string $glyph the glyphicon name to be used -ie "cloud"
     * @param array $options the tag options in terms of name-value pairs.
     *
     * @return string the generated labeled icon button tag
     */
    public static function labeledIconButton($label, $glyph, $options = [])
    {
        $iOptions = ArrayHelper::remove($options, 'icon', []);
        $icon = static::icon($glyph, $iOptions);
        Ui::addCssClasses($options, ['labeled', 'icon']);
        return static::button($icon . $label, $options);
    }

    /**
     * Generates a [button group](http://semantic-ui.com/elements/button.html#buttons)
     *
     * @param array $buttons the array of button options in terms of name-value pairs to render. The following options
     * are specially handled:
     * - label: string, the label of the button. Defaults to 'label'
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated button group tag
     */
    public static function buttonGroup($buttons = [], $options = [])
    {
        Ui::addCssClasses($options, ['ui', 'buttons']);
        $lines = [];
        foreach ($buttons as $button) {
            $label = ArrayHelper::remove($button, 'label', Yii::t('dosamigos/semantic/helpers', 'label'));
            $lines[] = static::button($label, $button);
        }
        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Generates a [conditional button](http://semantic-ui.com/elements/button.html#conditionals)
     *
     * @param string $leftLabel the label to appear on the left side
     * @param string $rightLabel the label to appear on the right side
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated conditional button tag
     */
    public static function conditionalButton($leftLabel, $rightLabel, $options = [])
    {
        $lOptions = ArrayHelper::remove($options, 'left', []);
        $rOptions = ArrayHelper::remove($options, 'right', []);
        $oOptions = ArrayHelper::remove($options, 'or', []);

        Ui::addCssClasses($options, ['ui', 'buttons']);
        Ui::addCssClasses($lOptions, ['ui', 'button']);
        Ui::addCssClasses($rOptions, ['ui', 'button']);
        Html::addCssClass($oOptions, 'or');

        $lines = [];
        $lines[] = static::button($leftLabel, $lOptions);
        $lines[] = Html::tag('div', '', $oOptions);
        $lines[] = static::button($rightLabel, $rOptions);

        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Renders an [icon tag](http://semantic-ui.com/elements/icon.html)
     *
     * @param string $glyph the name of the icon to render -ie "cloud"
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated icon tag
     */
    public static function icon($glyph, $options = [])
    {
        Ui::addCssClasses($options, ['icon', $glyph]);
        return Html::tag('i', '', $options);
    }

    /**
     * Renders a [divider](http://semantic-ui.com/elements/divider.html)
     *
     * @param string $label the label
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated divider tag
     */
    public static function divider($label, $options = [])
    {
        Ui::addCssClasses($options, ['ui', 'divider']);

        return Html::tag('div', $label, $options);
    }

    /**
     * Renders a [flag](http://semantic-ui.com/elements/flag.html)
     *
     * @param string $country the flag's country ISO code to render
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated flag tag
     */
    public static function flag($country, $options = [])
    {
        Ui::addCssClasses($options, ['flag', $country]);
        return Html::tag('i', '', $options);
    }

    /**
     * Renders an [avatar image](http://semantic-ui.com/elements/image.html#avatar)
     *
     * @param string $src the image source
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated avatar tag
     */
    public static function avatar($src, $options = [])
    {
        Ui::addCssClasses($options, ['ui', 'avatar', 'image']);
        return Html::img($src, $options);
    }

    /**
     * Renders a [label](http://semantic-ui.com/elements/label.html)
     *
     * @param string $content the label content
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated label tag
     */
    public static function label($content, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        Ui::addCssClasses($options, ['ui', 'label']);
        return Html::tag($tag, $content, $options);
    }

    /**
     * Generates a [label that contains a detail](http://semantic-ui.com/elements/label.html#detail)
     *
     * @param string $content the content of the label
     * @param string $detail the detail of the label
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated label with detail tag
     */
    public static function labelDetail($content, $detail, $options = [])
    {
        $detail = Html::tag('div', $detail, ['class' => 'detail']);
        return static::label($content . $detail, $options);
    }

    /**
     * Generates a [tag label](http://semantic-ui.com/elements/label.html#tag)
     *
     * @param string $content the content of the tag label
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated tag label HTML tag
     */
    public static function labelTag($content, $options = [])
    {
        Html::addCssClass($options, 'tag');
        return static::label($content, $options);
    }

    /**
     * Generates a label ribbon
     *
     * @param string $content the content of the ribbon label
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated ribbon label
     */
    public static function labelRibbon($content, $options = [])
    {
        Html::addCssClass($options, 'ribbon');
        return static::label($content, $options);
    }

    /**
     * Generates a group of labels. Very useful when working with label tags
     *
     * @param array $labels the array of tag options in terms name-value pairs of . They support a special tag:
     * - content: string, will be extracted from the options
     * @param array $options the tag options in terms of name-value pairs of the layer containing the label group
     *
     * @return string the generated label group tag
     */
    public static function labelGroup($labels = [], $options = [])
    {
        Ui::addCssClasses($options, ['ui', 'labels']);
        $lines = [];
        foreach ($labels as $label) {
            $content = ArrayHelper::remove($label, 'content');
            $lines[] = static::label($content, $label);
        }
        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * @param $items
     * @param array $options
     *
     * @return string
     */
    public static function groupList($items, $options = [])
    {
        Ui::addCssClasses($options, ['ui', 'list']);
        $lines = [];
        foreach ($items as $item) {
            if (is_string($item)) {
                $lines[] = $item;

            } else {
                $icon = ArrayHelper::remove($item, 'icon');
                $image = ArrayHelper::remove($item, 'image');
                $header = ArrayHelper::remove($item, 'header');
                $description = ArrayHelper::remove($item, 'description');
                if ($description) {
                    $description = Html::tag('div', $description, ['class' => 'description']);
                }

                $content = [];
                $content[] = $icon;
                $content[] = $image;
                if ($header || $description) {
                    $content[] = Html::tag('div', $header . $description, ['class' => 'content']);
                }
                $lines[] = Html::tag('div', implode("\n", $content), $item);
            }
        }
        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * @param $visibleSrc
     * @param $hiddenSrc
     * @param array $options
     *
     * @return string
     */
    public static function imgReveal($visibleSrc, $hiddenSrc, $options = [])
    {
        $lines = [];

        $visibleOptions = ArrayHelper::remove($options, 'visible', []);
        Ui::addCssClasses($visibleOptions, ['visible', 'content']);
        $lines[] = Html::img($visibleSrc, $visibleOptions);

        $hiddenOptions = ArrayHelper::remove($options, 'hidden', []);
        Ui::addCssClasses($hiddenOptions, ['hidden', 'content']);
        $lines[] = Html::img($hiddenSrc, $hiddenOptions);

        Ui::addCssClasses($options, ['ui', 'reveal']);
        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * @param $items
     * @param array $options
     *
     * @return string
     */
    public static function steps($items, $options = [])
    {
        $steps = array_map(
            function ($item) {
                $tag = ArrayHelper::remove($item, 'tag', 'div');
                $icon = ArrayHelper::remove($item, 'icon', '');
                $title = ArrayHelper::remove($item, 'title', '');
                $description = ArrayHelper::remove($item, 'description');

                if (!empty($title)) {
                    $title = Html::tag('div', $title, ['class' => 'title']);
                }
                if (!empty($description)) {
                    $description = Html::tag('div', $description, ['class' => 'description']);
                }
                if (!empty($icon)) {
                    $icon = static::icon($icon);
                    $content = Html::tag('div', $title . $description, ['class' => 'content']);
                } else {
                    $content = $title . $description;
                }

                Html::addCssClass($item, 'step');
                return Html::tag($tag, $icon . $content, $item);
            },
            $items
        );

        Ui::addCssClasses($options, ['ui', 'steps']);

        return Html::tag('div', implode("\n", $steps), $options);
    }
}