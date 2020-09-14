<?php

namespace App\Components\Columns;

use Closure;
use Form;
use Html;

class DataColumn extends Column
{
    public $attribute;

    public $label;

    public $encodeLabel = true;

    public $value;

    public $filterFormat = 'text';

    public $filterOptions = ['class' => 'form-control'];

    public $enableDownload = true;

    public $downloadValue;

    public function renderHeaderCellContent(): ?string
    {
        if ($this->header !== null || ($this->label === null && $this->attribute === null)) {
            return parent::renderHeaderCellContent();
        }

        $label = $this->getHeaderCellLabel();
        if ($this->encodeLabel) {
            $label = htmlspecialchars($label, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
        }

        return $label;
    }

    protected function getHeaderCellLabel(): ?string
    {
        if ($this->label === null) {
            $label = $this->attribute;
        } else {
            $label = $this->label;
        }

        return $label;
    }

    public function getDataCellValue($model, $index)
    {
        if ($this->value !== null) {
            if ($this->value instanceof Closure) {
                return call_user_func($this->value, $model);
            }

            if (is_string($this->value)) {
                return $model[$this->value] ?? null;
            }

            return null;
        }

        if ($this->attribute !== null) {
            return $model[$this->attribute] ?? null;
        }

        return null;
    }

    protected function renderDataCellContent($model, $index)
    {
        if ($this->content === null) {
            return $this->getDataCellValue($model, $index);
        }

        return parent::renderDataCellContent($model, $index);
    }

    /**
     * @param $model
     * @param $index
     *
     * @return string
     */
    public function getDownloadDataCellContent($model, $index): ?string
    {
        if ($this->downloadValue !== null) {
            if ($this->downloadValue instanceof Closure) {
                return call_user_func($this->downloadValue, $model);
            }

            if (is_string($this->downloadValue)) {
                return $model[$this->downloadValue] ?? null;
            }

            return null;
        }

        return $this->renderDataCellContent($model, $index);
    }

    /**
     * @return mixed|string
     * @throws \RuntimeException
     */
    public function renderFilter(): ?string
    {
        if ($this->filter === false) {
            return parent::renderFilter();
        }

        if ($this->filter instanceof Closure) {
            return call_user_func($this->filter, $this);
        }

        if (empty($this->filterFormat)) {
            throw new \RuntimeException('filterType cannot be empty!');
        }

        if ($this->filterOptions instanceof Closure) {
            $this->filterOptions = call_user_func($this->filterOptions, $this);
        }

        $name        = $this->attribute;
        $placeholder = empty($this->filterOptions['placeholder']) ? $this->getHeaderCellLabel() :
            $this->filterOptions['placeholder'];
        $value       = request($name);

        $divTemplate = Html::tag('div', Html::tag('div', Html::tag('div', '%s', [
            'class' => 'input-group input-group-merge',
        ])->toHtml(), ['class' => 'js-focus-state'])->toHtml(), ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-3'])
            ->toHtml();

        $textSearchIcon = Html::tag('div', Html::tag('i', '', [
            'class' => 'nova-search icon-text icon-text-sm',
        ])->toHtml(), [
            'class' => 'input-group-append',
        ])->toHtml();

        switch ($this->filterFormat) {
            case 'text':
                return sprintf($divTemplate, $textSearchIcon . Form::text($name, $value, array_merge([
                        'placeholder' => $placeholder,
                    ], $this->filterOptions))->toHtml());
            case 'select':
                $list              = $this->filterOptions['items'] ?? [];
                $selected          = $value ?? ($this->filterOptions['selected'] ?? null);
                $selectAttributes  = array_merge([
                    'placeholder'  => $placeholder,
                    'class'        => 'form-control js-custom-select',
                    'style'        => 'width:100%',
                    'data-classes' => 'select select-bordered rounded',
                ], $this->filterOptions['selected_attributes'] ?? []);
                $optionsAttributes = $this->filterOptions['options_attributes'] ?? [];

                return sprintf(
                    $divTemplate,
                    Form::select($name, $list, $selected, $selectAttributes, $optionsAttributes)->toHtml()
                );
            default:
                throw new \RuntimeException(sprintf('Unsupported filterType: %s', $this->filterFormat));
        }
    }
}
