<?php

namespace App\Components\Columns;

class SerialColumn extends Column
{
    public $header = '#';

    protected function renderDataCellContent($model, $index)
    {
        $pagination = $this->table->getData();

        return $pagination->perPage() * ($pagination->currentPage() - 1) + $index + 1;
    }
}
