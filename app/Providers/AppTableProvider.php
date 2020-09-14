<?php

namespace App\Providers;

use App\Components\Buttons\BaseButton;
use App\Components\Buttons\DownloadButton;
use App\Components\Buttons\LinkButton;
use App\Components\Export\CsvExport;
use App\Components\Export\ExcelExport;
use App\Components\Export\ExportFactory;
use App\Services\Tables\Impls\ResourcesTable;
use App\Services\Tables\ResourcesTableContract;
use Illuminate\Support\ServiceProvider;

class AppTableProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bindTableContracts();
    }

    /**
     * Table组件契约实现
     */
    protected function bindTableContracts()
    {
        $this->app->bind(ResourcesTableContract::class, ResourcesTable::class);
    }

    public function register()
    {
        $this->app->singleton(BaseButton::class, static function ($app, $params) {
            return new BaseButton($params);
        });
        $this->app->singleton(DownloadButton::class, static function ($app, $params) {
            return new DownloadButton($params);
        });
        $this->app->singleton(LinkButton::class, static function ($app, $params) {
            return new LinkButton($params);
        });
        $this->app->singleton(ExportFactory::FILE_TYPE_EXCEL, static function ($app, $params) {
            return new ExcelExport(...$params);
        });
        $this->app->singleton(ExportFactory::FILE_TYPE_CSV, static function ($app, $params) {
            return new CsvExport(...$params);
        });
    }
}