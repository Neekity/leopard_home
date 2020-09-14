<?php

namespace App\Components\Export;

use Closure;
use App\Components\Columns\DataColumn;
use App\Components\Table;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use Exportable;

    /**
     * @var \Kuainiu\OA\Widget\Table\Components\Table $table
     */
    protected $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $result       = [];
        $tableContent = $this->table->getData();
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

                $this->handleContent($result, $paginator);

                $page++;
            }
        } else {
            $this->handleContent($result, $tableContent);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headers = [];
        foreach ($this->table->getTableColumns() as $column) {
            if ($column instanceof DataColumn && $column->enableDownload) {
                $headers[] = $column->renderHeaderCellContent();
            }
        }

        return $headers;
    }

    /**
     * @param array                                       $content
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     */
    private function handleContent(array &$content, $paginator): void
    {
        foreach ($paginator->getCollection() as $index => $model) {
            $row = [];
            foreach ($this->table->getTableColumns() as $column) {
                if ($column instanceof DataColumn && $column->enableDownload) {
                    $row[] = $column->getDownloadDataCellContent($model, $index) ?? '';
                }
            }
            $content[] = $row;
        }
    }
}
