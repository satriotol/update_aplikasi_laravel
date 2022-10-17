<?php

namespace App\Exports;

Use Encore\Admin\Grid\Exporters\ExcelExporter;

class ApplicationExport extends ExcelExporter
{
    protected $fileName = 'List Aplikasi.xlsx';
    
    protected $columns = [
        'id' => 'ID',
        'url' => 'Nama Aplikasi',
        'category_id' => 'Deskripsi Fungsi Aplikasi',
        'whm_id' => 'Kode WHM',
    ];
}
