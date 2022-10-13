<?php

namespace App\Admin\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Category;
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
            $filter->equal('status')->select(Application::STATUSES);
        });
        $grid->column('id', __('Id'));
        $grid->column('category.name', __('Category'));
        $grid->column('user.name', __('PIC'));
        $grid->column('whm.name', __('Whm'));
        $grid->column('url', __('Url'))->link();
        $grid->column('note', __('Note'))->editable();
        $grid->column('updated_at', __('Tanggal Pemantauan'));
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
        $show->field('category.name', __('Category id'));
        $show->field('whm.name', __('Whm id'));
        $show->field('url', __('Url'))->link();
        $show->field('note', __('Note'));
        $show->field('updated_at', __('Updated at'));

        $show->application_statuses('Application Status', function ($applications_statuses) {
            $applications_statuses->model()->orderBy('id', 'desc');
            $applications_statuses->resource('/admin/application-statuses');
            $applications_statuses->status()->display(function ($title) {
                if ($this->title == 0) {
                    return ApplicationStatus::STATUSES[0];
                } else {
                    return ApplicationStatus::STATUSES[1];
                }
            });
            $applications_statuses->last_updated('Update Terakhir');
            $applications_statuses->updated_at('Di Cek');
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
        $form->hasMany('application_statuses', function (Form\NestedForm $form) {
            $form->select('status', __('Status'))->options(ApplicationStatus::STATUSES)->rules('required');
            $form->date('last_updated', __('Last updated'))->default(date('Y-m-d'));
        });

        return $form;
    }
}
