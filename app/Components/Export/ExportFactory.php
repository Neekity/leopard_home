<?php

namespace App\Components\Export;

class ExportFactory
{
    public const FILE_TYPE_EXCEL = 'xlsx';
    public const FILE_TYPE_CSV   = 'csv';
    public const FILE_TYPES      = [self::FILE_TYPE_CSV, self::FILE_TYPE_EXCEL];

    /**
     * @param                                       $type
     * @param \Kuainiu\OA\Widget\Table\Components\Table $table
     *
     * @return \Kuainiu\OA\Widget\Table\Components\Export\ExportInterface|\Kuainiu\OA\Widget\Table\Components\Export\ExcelExport
     * @throws \InvalidArgumentException
     */
    public static function make($type, $table)
    {
        if (!in_array($type, self::FILE_TYPES, false)) {
            throw new \InvalidArgumentException('unknown export type');
        }

        return app($type, [$table]);
    }
}
