<?php

namespace App\Components\Buttons;

use Illuminate\Contracts\Support\Htmlable;

abstract class Button implements Htmlable
{
    /**
     * @var string
     */
    public $label = 'Button';

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $js = '';

    /**
     * @var \Kuainiu\OA\Widget\Table\Components\Table
     */
    public $table;

    /**
     * @var array
     */
    public $options = [];

    public function __construct($properties = [])
    {
        foreach ($properties as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }

        if ($this->content === null) {
            $this->content = sprintf(
                '<i class="%s unfold-item-icon mr-3"></i><span class="media-body">%s</span>',
                empty($this->icon) ? 'nova-cloud-down' : $this->icon,
                $this->label
            );
        }
    }

    /**
     * @return string
     */
    public function renderJs(): ?string
    {
        return $this->js;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
