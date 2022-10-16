<?php

namespace App\Exports;

Use Encore\Admin\Grid\Exporters\ExcelExporter;

class ApplicationExport extends ExcelExporter
{
    protected $fileName = 'Article list.xlsx';
    
    protected $columns = [
        'id' => 'ID',
        'url' => 'Nama Aplikasi',
        'category_id' => 'Deskripsi Fungsi Aplikasi',
        'whm_id' => 'Kode WHM',
    ];
}
