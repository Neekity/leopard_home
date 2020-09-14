<?php

namespace App\Components\Columns;

use Html;

class ActionColumn extends Column
{
    public $template = '{view} {update} {delete}';

    public $buttons = [];

    public $buttonOptions = [];

    public function init(): void
    {
        parent::init();
        if (empty($this->buttons)) {
            $this->initDefaultButtons();
        }
    }

    protected function initDefaultButtons(): void
    {
        $this->initDefaultButton('view', 'nova-angle-right');
        $this->initDefaultButton('update', 'nova-angle-right');
        $this->initDefaultButton('delete', 'nova-angle-right');
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = []): void
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = static function ($model) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = '<text class="text-primary">查看<i class="%s"></i></text>';
                        break;
                    case 'update':
                        $title = '<text class="text-info">编辑<i class="%s"></i></text>';
                        break;
                    case 'delete':
                        $title = '<text class="text-danger">删除<i class="%s"></i></text>';
                        break;
                    default:
                        $title = ucfirst($name);
                }

                return Html::link('/', sprintf($title, $iconName), [], null, false)->toHtml();
            };
        }
    }

    public function renderDataCellContent($model, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $index) {
            $name = $matches[1];

            if (isset($this->buttons[$name])) {
                return call_user_func($this->buttons[$name], $model);
            }

            return '';
        }, $this->template);
    }
}
