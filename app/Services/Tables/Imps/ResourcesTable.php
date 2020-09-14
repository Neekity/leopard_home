<?php

namespace App\Services\Tables\Impls;

use App\Services\Tables\ResourcesTableContract;
use Html;
use App\Components\Columns\ActionColumn;
use App\Components\Columns\SerialColumn;
use App\Components\Table;

class ResourcesTable extends Table implements ResourcesTableContract
{
    public $showFilter = true;
    //    public $showHeaderButtons = true;

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return [
            [
                'class'          => SerialColumn::class,
                'headerOptions'  => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'header'         => '序号',
            ],
            [
                'headerOptions'  => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'label'          => '资源名称',
                'filter'         => true,
                'attribute'      => 'fileName',
            ],
            [
                'headerOptions'  => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'label'          => '文件类型',
                'filter'         => true,
                'attribute'      => 'fileType',
            ],
            [
                'headerOptions'  => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'label'          => '上传者',
                'attribute'      => 'uploadName',
                'value'          => function ($model) {
                    return $model->uploader->name;
                },
            ],
            [
                'headerOptions'  => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'label'          => '上传日期',
                'attribute'      => 'created_at',
            ],
            [
                'class'          => ActionColumn::class,
                'headerOptions'  => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center align-middle'],
                'header'         => '操作',
                'template'       => '{view}{delete}',
                'buttons'        => [
                    'delete' => function ($model) {
                        return Html::tag('a', '<text class="text-danger">删除</text>', [
                                'href'                 => 'javascript:void(0);',
                                'class'                => 'btn-submit',
                                'data-call'            => 'ajax',
                                'data-url'             => route('resources.destroy', ['id' => $model['id']]),
                                'data-method'          => 'DELETE',
                                'data-confirm-message' => '即将删除此记录，确认继续？',
                            ]) . '<span class="nova-trash ml-1 v-align-middle"></span>';
                    },
                    'view'   => function ($model) {
                        return Html::link($model->fileUrl, '<text class="text-info">查看<i class="nova-clipboard ml-1 mr-4 font-size-xs"></i></text>', [
                            'target' => '_blank',
                        ], null, false);
                    },
                ],
            ],
        ];
    }

    public function getHeaderButtons(): ?array
    {
        return [
            [
                'content' => '<i class="nova-plus unfold-item-icon mr-3"></i><span class="media-body">上传文件</span>',
                'options' => [
                    'href'        => 'javascript:void(0);',
                    'class'       => 'unfold-link media align-items-center text-nowrap btn-create-resources',
                    'data-url'    => route('resources.index'),
                    'data-method' => 'POST',
                ],
            ],
        ];
    }
}
