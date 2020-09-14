<?php

namespace App\Components\Export;

use App\Components\Columns\DataColumn;
use Closure;

class CsvExport extends BaseExport
{
    public function download(string $filename)
    {
        set_time_limit(0);
        ini_set("memory_limit", '-1');
        header("Content-Type: application/csv");
        header("Charset=UTF-8");
        header("Content-Disposition: attachment; filename=$filename");
        $output = fopen('php://output', 'ab') or die("Can't open php://output");

        $tableColumns = $this->table->getTableColumns();
        $tableContent = $this->table->getData();

        $headers = [];
        foreach ($tableColumns as $column) {
            if ($column instanceof DataColumn && $column->enableDownload) {
                $headers[] = $column->renderHeaderCellContent();
            }
        }

        // 写入表头
        fputcsv($output, $headers);

        if ($tableContent instanceof Closure) {
            $page = 1;
            while (true) {
                /**
                 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
                 */
                $paginator = $tableContent($page);
                if ($paginator->getCollection()->isEmpty()) {
                    break;
                }

                $this->writeContent($output, $tableColumns, $paginator);

                $page++;
            }
        } else {
            $this->writeContent($output, $tableColumns, $tableContent);
        }

        // 关闭文件流
        fclose($output);
    }

    /**
     * @param resource                                         $handle
     * @param \Kuainiu\OA\Widget\Table\Components\Columns\Column[] $tableColumns
     * @param \Illuminate\Pagination\LengthAwarePaginator      $paginator
     */
    private function writeContent($handle, $tableColumns, $paginator)
    {
        foreach ($paginator->getCollection() as $index => $model) {
            $cells = [];
            foreach ($tableColumns as $column) {
                if ($column instanceof DataColumn && $column->enableDownload) {
                    $cells[] = $column->getDownloadDataCellContent($model, $index) ?? '';
                }
            }

            fputcsv($handle, $cells);

            ob_flush();

            flush();
        }
    }
}
