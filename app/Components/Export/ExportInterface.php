<?php

namespace App\Components\Export;

interface ExportInterface
{
    /**
     * @param string $filename
     *
     * @return mixed
     */
    public function download(string $filename);
}
