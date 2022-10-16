<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\Whm;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Dashboard')
            // ->row(Dashboard::title())
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(new InfoBox('Website', 'users', 'aqua', '/admin/applications', Application::all()->count()));
                });
                $row->column(6, function (Column $column) {
                    $column->append(new InfoBox('Website Aktif', 'users', 'green', '/admin/applications', Application::whereHas('application_status', function ($q) {
                        $q->where('status_id', 1);
                    })->get()->count()));
                });
                $row->column(6, function (Column $column) {
                    $column->append(new InfoBox('Website Suspend', 'users', 'red', '/admin/applications', Application::whereHas('application_status', function ($q) {
                        $q->where('status_id', 2);
                    })->get()->count()));
                });
                // $row->column(6, function (Column $column) {
                //     $column->append(new InfoBox('Website Suspend', 'users', 'red', '/admin/applications?status=1', Application::where('status', 1)->get()->count()));
                // });
            });
    }
}
