<?php

namespace App\Components\Buttons;

use Html;

class BaseButton extends Button
{
    /**
     * @return string
     */
    public function toHtml(): ?string
    {
        return Html::tag('li', $this->content, ['class' => 'unfold-item'])->toHtml();
    }
}
