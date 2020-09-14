<?php

namespace App\Components\Columns;

use Closure;
use Exception;
use Form;

class CheckboxColumn extends Column
{
    public $name = 'selection';

    public $checkboxOptions = [];

    /**
     * @var bool|Closure
     */
    public $showCheckbox = true;

    public $multiple = true;

    public $cssClass;

    public function init(): void
    {
        parent::init();
        if (empty($this->name)) {
            throw new Exception('The "name" property must be set.');
        }
        if (substr_compare($this->name, '[]', -2, 2)) {
            $this->name .= '[]';
        }
        $this->registerClientScript();
    }

    public function renderHeaderCellContent(): ?string
    {
        if ($this->header !== null || !$this->multiple) {
            return parent::renderHeaderCellContent();
        }

        return Form::checkbox($this->getHeaderCheckBoxName(), 1, false, ['class' => 'select-on-check-all'])
            ->toHtml();
    }

    public function renderDataCellContent($model, $index)
    {
        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }

        if ($this->cssClass !== null) {
            $this->addCssClass($options, $this->cssClass);
        }

        if ($this->showCheckbox instanceof Closure) {
            $showCheckbox = call_user_func($this->showCheckbox, $model, $index, $this);
        } else {
            $showCheckbox = (bool)$this->showCheckbox;
        }

        return $showCheckbox === true ? Form::checkbox(
            $this->name,
            array_key_exists('value', $options) ? $options['value'] : '1',
            !empty($options['checked']),
            $options
        )->toHtml() : '';
    }

    protected function addCssClass(&$options, $class): void
    {
        if (isset($options['class'])) {
            if (is_array($options['class'])) {
                $options['class'] = $this->mergeCssClasses($options['class'], (array)$class);
            } else {
                $classes          = preg_split('/\s+/', $options['class'], -1, PREG_SPLIT_NO_EMPTY);
                $options['class'] = implode(' ', $this->mergeCssClasses($classes, (array)$class));
            }
        } else {
            $options['class'] = $class;
        }
    }

    protected function mergeCssClasses(array $existingClasses, array $additionalClasses)
    {
        foreach ($additionalClasses as $key => $class) {
            if (is_int($key) && !in_array($class, $existingClasses, false)) {
                $existingClasses[] = $class;
            } elseif (!isset($existingClasses[$key])) {
                $existingClasses[$key] = $class;
            }
        }

        return array_unique($existingClasses);
    }

    protected function getHeaderCheckBoxName(): string
    {
        $name = $this->name;
        if (substr_compare($name, '[]', -2, 2) === 0) {
            $name = substr($name, 0, -2);
        }
        if (substr_compare($name, ']', -1, 1) === 0) {
            $name = substr($name, 0, -1) . '_all]';
        } else {
            $name .= '_all';
        }

        return $name;
    }

    public function registerClientScript(): void
    {
        $options = json_encode([
            'name'     => $this->name,
            'class'    => $this->cssClass,
            'multiple' => $this->multiple,
            'checkAll' => $this->getHeaderCheckBoxName(),
        ]);

        $this->table->jsOptions = array_merge($this->table->jsOptions, [
            'setSelectionColumn' => $options,
        ]);
    }
}
