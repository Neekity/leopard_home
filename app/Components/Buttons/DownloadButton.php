<?php

namespace App\Components\Buttons;

use Html;
use App\Components\Export\ExportFactory;

class DownloadButton extends Button
{
    /**
     * @var string
     */
    public $label    = 'Export Csv File';
    public $fileType = ExportFactory::FILE_TYPE_CSV;

    public $options = [
        'class' => 'unfold-link media align-items-center text-nowrap btn-download',
        'href'  => 'javascript:void(0);',
    ];

    /**
     * @return string
     */
    public function toHtml(): ?string
    {
        return Html::tag('li', Html::tag('a', $this->content, array_merge([
            'class'     => 'unfold-link media align-items-center text-nowrap',
            'data-type' => $this->fileType,
        ], $this->options))->toHtml(), ['class' => 'unfold-item'])->toHtml();
    }

    /**
     * @return string
     */
    public function renderJs(): ?string
    {
        if (empty($this->js)) {
            return <<<EOF
jQuery('.btn-download').click(function () {
        window.location.href = window.location.pathname + '?' + $('#{$this->table->filterFormId}').serialize() +
            '&download=1&file_type=' + $(this).data('type');
    });
EOF;
        }

        return parent::renderJs();
    }
}
