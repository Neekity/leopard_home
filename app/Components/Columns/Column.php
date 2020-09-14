<?php

namespace App\Components\Columns;

use Html;
use Closure;

class Column
{
    /**
     * @var \Kuainiu\OA\Widget\Table\Components\Table
     */
    public $table;

    /**
     * @var string
     */
    public $header;

    public $content;

    public $headerOptions = [];

    public $contentOptions = [];

    public $label;

    /**
     * @var bool|Closure
     */
    public $filter = false;

    public $enableDownload = false;

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
        $this->init();
    }

    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    public function init(): void
    {
    }

    public function renderFilter(): ?string
    {
        return '';
    }

    public function renderHeaderCell(): ?string
    {
        return Html::tag('th', $this->renderHeaderCellContent(), $this->headerOptions)->toHtml();
    }

    public function renderHeaderCellContent(): ?string
    {
        return trim($this->header) !== '' ? $this->header : $this->getHeaderCellLabel();
    }

    public function renderDataCell($model, $index): string
    {
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        return Html::tag('td', (string)$this->renderDataCellContent($model, $index), $options)->toHtml();
    }

    protected function renderDataCellContent($model, $index)
    {
        if ($this->content !== null) {
            return call_user_func($this->content, $model, $index, $this);
        }

        return $this->table->emptyCell;
    }

    public function getDownloadDataCellContent($model, $index): ?string
    {
        return $this->table->emptyCell;
    }

    protected function getHeaderCellLabel(): ?string
    {
        return $this->table->emptyCell;
    }
}
