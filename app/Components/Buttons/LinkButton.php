<?php

namespace App\Components\Buttons;

use Html;

class LinkButton extends Button
{
    /**
     * @var string
     */
    public $url;

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return Html::tag('li', Html::tag('a', $this->content, array_merge([
            'href'  => $this->url,
            'class' => 'unfold-link media align-items-center text-nowrap',
        ], $this->options))->toHtml(), ['class' => 'unfold-item'])->toHtml();
    }
}
