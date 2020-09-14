<?php

namespace App\Components;

use Closure;
use Form;
use Html;
use Illuminate\Contracts\Support\Htmlable;
use App\Components\Buttons\BaseButton;
use App\Components\Columns\DataColumn;
use App\Components\Export\ExportFactory;
use App\Components\Contracts\TableContract;

abstract class Table implements Htmlable, TableContract
{
    /**
     * @var array $tableOption
     */
    public $tableOptions = ['class' => 'table table-bordered text-nowrap'];

    public $emptyCell = '&nbsp;';

    public $rowOptions = [];

    public $headerRowOptions = [];

    public $jsOptions = [];

    public $showHeader = true;

    public $showFilter = false;

    public $filterOptions = ['class' => 'row'];

    public $filterFormId = 'search-form';

    public $filterFormMethod = 'GET';

    public $showHeaderButtons = false;

    /**
     * @var App\Components\Buttons\Button[]|array
     */
    public $headerButtons = [];

    protected $table;

    protected $tableView;

    protected $data;

    /**
     * @var App\Components\Columns\Column[]
     */
    protected $tableColumns;

    public function __construct()
    {
        $this->init();
    }

    /**
     * @throws \Exception
     */
    protected function init(): void
    {
        $this->initColumns();
    }

    /**
     * @throws \Exception
     */
    protected function initColumns(): void
    {
        foreach ($this->getColumns() as $i => $column) {
            $class                  = $column['class'] ?? DataColumn::class;
            $this->tableColumns[$i] = new $class(array_merge(['table' => $this], $column));
        }

        $this->tableOptions = array_merge($this->tableOptions, ['id' => (new \ReflectionClass($this))->getShortName()]);
    }

    /**
     * @return App\Components\Columns\Column[]
     */
    public function getTableColumns(): array
    {
        return $this->tableColumns;
    }

    /**
     * @return string
     */
    public function renderHeaderButtons(): string
    {
        if ($this->showHeaderButtons === false) {
            return '';
        }

        foreach ($this->getHeaderButtons() as $headerButton) {
            if (isset($headerButton['class'])) {
                $class = $headerButton['class'];
                unset($headerButton['class']);
                $this->headerButtons[] = app($class, array_merge($headerButton, ['table' => $this]));
            } elseif ($headerButton instanceof Closure) {
                $this->headerButtons[] = app(BaseButton::class, [
                    'content' => $headerButton($this),
                    'js'      => $headerButton['js'] ?? '',
                ]);
            } elseif (is_array($headerButton)) {
                $this->headerButtons[] = app(BaseButton::class, [
                    'content' => Html::tag('a', $headerButton['content'], array_merge([
                        'class' => 'unfold-link media align-items-center text-nowrap',
                    ], $headerButton['options']))->toHtml(),
                    'table'   => $this,
                    'js'      => $headerButton['js'] ?? '',
                ]);
            }
        }

        $tableId = $this->tableOptions['id'];

        $dropDownButton = Html::tag('a', '<i class="nova-more-alt"></i>', [
            'class'                     => 'unfold-invoker d-flex',
            'href'                      => 'javascript:void(0);',
            'id'                        => $tableId . 'DropDownInvoker',
            'aria-controls'             => $tableId . 'DropDown',
            'aria-haspopup'             => 'true',
            'aria-expanded'             => 'false',
            'data-unfold-target'        => '#' . $tableId . 'DropDown',
            'data-unfold-event'         => 'click',
            'data-unfold-type'          => 'css-animation',
            'data-unfold-duration'      => '300',
            'data-unfold-animation-in'  => 'fadeIn',
            'data-unfold-animation-out' => 'fadeOut',
        ]);

        $dropDownMenus = Html::tag('ul', implode("\n", $this->headerButtons), [
            'class'           => 'unfold unfold-light unfold-top unfold-right position-absolute py-3 mt-3',
            'aria-labelledby' => $tableId . 'DropDownInvoker',
            'id'              => $tableId . 'DropDown',
        ])->toHtml();

        return Html::tag('div', Html::tag('div', $dropDownButton . $dropDownMenus, [
            'class' => 'position-relative ml-auto',
        ])->toHtml(), ['class' => 'd-flex align-items-center px-3']);
    }

    public function renderFilter(): string
    {
        if ($this->showFilter === false) {
            return '';
        }

        $filters = [];
        foreach ($this->tableColumns as $column) {
            $filters[] = $column->renderFilter();
        }

        return Form::open(array_merge([
                'method' => $this->filterFormMethod,
                'id'     => $this->filterFormId,
            ], $this->filterOptions))->toHtml() . implode("\n", $filters) . Form::close();
    }

    /**
     * @return string
     */
    public function renderTable(): string
    {
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody   = $this->renderTableBody();

        $content = array_filter([
            $tableHeader,
            $tableBody,
        ]);

        return Html::tag('table', implode("\n", $content), $this->tableOptions)->toHtml();
    }

    /**
     * @return string
     */
    public function renderTableHeader(): string
    {
        $cells = [];
        foreach ($this->tableColumns as $column) {
            $cells[] = $column->renderHeaderCell();
        }
        $content = Html::tag('tr', implode('', $cells), $this->headerRowOptions)->toHtml();

        return "<thead>\n" . $content . "\n</thead>";
    }

    /**
     * @return string
     */
    public function renderTableBody(): string
    {
        $models = $this->getData();
        $rows   = [];
        foreach ($models as $index => $model) {
            $rows[] = $this->renderTableRow($model, $index);
        }

        if (empty($rows)) {
            $rows[] = Html::tag('tr', Html::tag('td', '暂无相关数据', [
                'class'   => 'py-2',
                'colspan' => count($this->tableColumns),
            ])->toHtml())->toHtml();
        }

        return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
    }

    /**
     * @param $model
     * @param $index
     *
     * @return string
     */
    public function renderTableRow($model, $index): string
    {
        $cells = [];
        foreach ($this->tableColumns as $column) {
            $cells[] = $column->renderDataCell($model, $index);
        }
        if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $index, $this);
        } else {
            $options = $this->rowOptions;
        }

        return Html::tag('tr', implode('', $cells), $options)->toHtml();
    }

    /**
     * @param $data
     *
     * @return $this|App\Contracts\TableContract
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator|Closure
     */
    public function getData()
    {
        return $this->data;
    }

    public function toHtml(): string
    {
        return view($this->getView(), array_merge(['table' => $this], func_get_args()))->render();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return $this->renderOn('table.index');
    }

    /**
     * @param string $viewName
     * @param array  $data
     * @param string $as
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderOn(string $viewName, $data = [], $as = 'table')
    {
        return view($viewName, array_merge($data, [$as => $this]));
    }

    public function getView(): string
    {
        if ($this->tableView === null) {
            $this->tableView = 'table.table';
        }

        return $this->tableView;
    }

    public function getColumns(): ?array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getHeaderButtons(): ?array
    {
        return [];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * @param string $fileName
     * @param string $fileType
     *
     * @return mixed
     */
    public function download(string $fileName, $fileType = ExportFactory::FILE_TYPE_CSV)
    {
        return ExportFactory::make($fileType, $this)->download($fileName);
    }
}
