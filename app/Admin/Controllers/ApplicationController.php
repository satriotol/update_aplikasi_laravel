<?php

namespace App\Admin\Controllers;

use App\Exports\ApplicationExport;
use App\Models\Application;
use App\Models\Category;
use App\Models\Status;
use App\Models\Whm;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;


class ApplicationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Application';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Application());
        $grid->filter(function ($filter) {

            $filter->disableIdFilter();
            $filter->like('category.name', 'category');
            $filter->like('user.name', 'user');
            $filter->like('whm.name', 'whm');
            $filter->equal('application_status.status_id', 'Status')->select(Status::all()->pluck('name', 'id'));
        });
        $grid->export(function ($export) {

            $export->filename('Report_Aplikasi');
            $export->originalValue(['url', 'note']);
        });
        // $grid->exporter(new ApplicationExport());
        $grid->column('id', __('Id'));
        $grid->column('category.name', __('Category'));
        $grid->column('user.name', __('PIC'));
        $grid->column('whm.name', __('Whm'));
        $grid->column('url', __('Url'))->link();
        $grid->column('note', __('Note'))->editable('textarea');
        $grid->column('application_status.status_name', 'Status');
        $grid->column('application_status.created_at', 'Created At');
        // $grid->application_statuses('Status')->last();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Application::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('user.name', __('PIC'));
        $show->field('category.name', __('Category'));
        $show->field('whm.name', __('Whm id'));
        $show->field('url', __('Url'))->link();
        $show->field('note', __('Note'));

        $show->application_statuses('Application Status', function ($applications_statuses) use ($id) {
            $applications_statuses->quickCreate(function (Grid\Tools\QuickCreate $create) use ($id) {
                $create->select('status_id', __('Status'))->options(Status::all()->pluck('name', 'id'))->rules('required');
                $create->date('last_updated', __('Last updated'))->default(date('Y-m-d'))->rules('required');
                $create->hidden('application_id', __('Application id'))->default($id);
            });
            $applications_statuses->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableView();
            });
            $applications_statuses->disableCreateButton();
            $applications_statuses->disableFilter();
            $applications_statuses->disableExport();
            $applications_statuses->model()->orderBy('id', 'desc');
            $applications_statuses->resource('/admin/application-statuses');
            $applications_statuses->status_id('Status')->editable('select', Status::all()->pluck('name', 'id'));
            $applications_statuses->last_updated('Update Terakhir')->editable('date');
            $applications_statuses->created_at('Di Cek')->date();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Application());

        $form->select('category_id', 'Category')->options(Category::all()->pluck('name', 'id'))->rules('required');
        $form->select('whm_id', 'WHM')->options(Whm::all()->pluck('name', 'id'))->rules('required');
        $form->textarea('url', __('Url'))->rules('required');
        $form->textarea('note', __('Note'));
        $form->hidden('user_id');
        $form->saving(function (Form $form) {
            $form->user_id = Auth::user()->id;
        });
        return $form;
    }
}
