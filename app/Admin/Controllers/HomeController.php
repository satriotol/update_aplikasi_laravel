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
                $row->column(4, function (Column $column) {
                    $column->append(new InfoBox('Website', 'users', 'green', '/admin/applications', Application::all()->count()));
                });
                $row->column(4, function (Column $column) {
                    $column->append(new InfoBox('Whm', 'users', 'aqua', '/admin/whms', Whm::all()->count()));
                });
                $row->column(4, function (Column $column) {
                    $column->append(new InfoBox('Category', 'users', 'aqua', '/admin/categories', Category::all()->count()));
                });

            });
    }
}
