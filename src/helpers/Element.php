<?php
/**
 * @link https://github.com/2amigos/yii2-semantic-ui
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace dosamigos\semantic\helpers;

use Yii;
use yii\helpers\ArrayHelper;

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
            ? Ui::button($content, $options)
            : Ui::tag($tag, $content, $options);
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
        $lines[] = Ui::tag('div', $hidden, $hOptions);
        $lines[] = Ui::tag('div', $visible, $vOptions);

        return Ui::tag('div', implode("\n", $lines), $options);

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
        return Ui::tag('div', implode("\n", $lines), $options);
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
        Ui::addCssClass($oOptions, 'or');

        $lines = [];
        $lines[] = static::button($leftLabel, $lOptions);
        $lines[] = Ui::tag('div', '', $oOptions);
        $lines[] = static::button($rightLabel, $rOptions);

        return Ui::tag('div', implode("\n", $lines), $options);
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
        return Ui::tag('i', '', $options);
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

        return Ui::tag('div', $label, $options);
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
        return Ui::tag('i', '', $options);
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
        return Ui::img($src, $options);
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
        return Ui::tag($tag, $content, $options);
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
        $detail = Ui::tag('div', $detail, ['class' => 'detail']);
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
        Ui::addCssClass($options, 'tag');
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
        Ui::addCssClass($options, 'ribbon');
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
        return Ui::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Generates a group list @see http://semantic-ui.com/elements/list.html
     *
     * @param array $items the items to render on the group. Each item configuration supports these special options:
     * - icon, string, optional, the item's icon
     * - image, string, optional, the item's image
     * - header, string, optional, the item's header
     * - description, string, option, the description of the item
     * @param array $options the tag options in terms of name-value pairs of the layer containing the list group
     *
     * @return string the generated list
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
                    $description = Ui::tag('div', $description, ['class' => 'description']);
                }

                $content = [];
                $content[] = $icon;
                $content[] = $image;
                if ($header || $description) {
                    $content[] = Ui::tag('div', $header . $description, ['class' => 'content']);
                }
                $lines[] = Ui::tag('div', implode("\n", $content), $item);
            }
        }
        return Ui::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Generates an image reveal element @see http://semantic-ui.com/elements/reveal.html
     *
     * @param string $visibleSrc the image source to be visible when render
     * @param string $hiddenSrc the image source to be hidden when render
     * @param array $options the tag options in terms of name-value pairs.
     *
     * @return string the generated reveal tag
     */
    public static function imgReveal($visibleSrc, $hiddenSrc, $options = [])
    {
        $lines = [];

        $visibleOptions = ArrayHelper::remove($options, 'visible', []);
        Ui::addCssClasses($visibleOptions, ['visible', 'content']);
        $lines[] = Ui::img($visibleSrc, $visibleOptions);

        $hiddenOptions = ArrayHelper::remove($options, 'hidden', []);
        Ui::addCssClasses($hiddenOptions, ['hidden', 'content']);
        $lines[] = Ui::img($hiddenSrc, $hiddenOptions);

        Ui::addCssClasses($options, ['ui', 'reveal']);
        return Ui::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Renders a segment @see http://semantic-ui.com/elements/segment.html
     *
     * @param string $content the content of the segment
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated segment tag
     */
    public static function segment($content, $options = [])
    {
        Ui::addCssClasses($options, ['ui', 'segment']);
        return Ui::tag('div', $content, $options);
    }

    /**
     * Renders a step element item @see http://semantic-ui.com/elements/step.html
     *
     * @param string $content the content of the item
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated step item tag
     */
    public static function step($content, $options = [])
    {
        Ui::addCssClass($options, 'step');
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Ui::tag($tag, $content, $options);
    }

    /**
     * Generates step element @see http://semantic-ui.com/elements/step.html
     *
     * @param array $items the configuration of the steps. The configuration options may include:
     * - tag, string, optional, the layer tag. Defaults to 'div'
     * - icon, string, optional, the icon to display on the step
     * - title, string, optional, the title of the step
     * - description, string, optional, the description of the step
     * @param array $options the tag options in terms of name-value pairs
     *
     * @return string the generated step tag
     */
    public static function steps($items, $options = [])
    {
        $steps = array_map(
            function ($item) {
                $icon = ArrayHelper::remove($item, 'icon', '');
                $title = ArrayHelper::remove($item, 'title', '');
                $description = ArrayHelper::remove($item, 'description');

                if (!empty($title)) {
                    $title = Ui::tag('div', $title, ['class' => 'title']);
                }
                if (!empty($description)) {
                    $description = Ui::tag('div', $description, ['class' => 'description']);
                }
                if (!empty($icon)) {
                    $icon = static::icon($icon);
                    $content = Ui::tag('div', $title . $description, ['class' => 'content']);
                } else {
                    $content = $title . $description;
                }
                return static::step($icon . $content, $item);
            },
            $items
        );

        Ui::addCssClasses($options, ['ui', 'steps']);

        return Ui::tag('div', implode("\n", $steps), $options);
    }
}
