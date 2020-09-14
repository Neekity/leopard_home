<?php

namespace App\Components\Export;

use App\Components\Table;

abstract class BaseExport implements ExportInterface
{
    protected $table;

    /**
     * @param \App\Components\Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }
}
