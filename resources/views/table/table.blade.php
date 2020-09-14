<?php
/**
 * @var \Illuminate\Support\Collection            $lists
 * @var App\Components\Table $table
 */
$paginator   = $table->getData();
$currentPage = $paginator->currentPage();
$lastPage    = $paginator->lastPage();
$perPage     = $paginator->perPage();
$total       = $paginator->total();
$itemIndex   = $perPage * ($currentPage - 1);
?>
<style>
    .table-responsive > .table-bordered {
        border: 1px solid #eeeef1 !important;
    }
</style>
<div class="card">
    <div class="card-header m-0 px-3 pt-3 pb-0">
        {!! $table->renderHeaderButtons() !!}
    </div>
    <div class="card-body p-3">
        {!! $table->renderFilter() !!}
        <div class="table-responsive">
            {!! $table->renderTable() !!}
        </div>
    </div>
    <div class="card-footer py-0 px-3">
        @if ($total > 0)
            <div class="pull-left">
                <p class="font-weight-semi-bold">第{{ $itemIndex + 1 }}-{{ $itemIndex + $paginator->getCollection()->count() }}条，共{{ $total }}条数据.</p>
            </div>
        @endif
        <div class="pull-right">
            {!! $table->getData()->appends(request()->all())->links() !!}
        </div>
    </div>
</div>
