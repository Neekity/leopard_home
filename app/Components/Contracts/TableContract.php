<?php

namespace App\Components\Contracts;

use App\Components\Export\ExportFactory;

interface TableContract
{
    /**
     * @param $data
     *
     * @return static
     */
    public function setData($data);

    public function render();

    public function renderOn(string $viewName, $data = [], $as = 'table');

    public function getColumns();

    public function download(string $fileName, $fileType = ExportFactory::FILE_TYPE_CSV);
}
