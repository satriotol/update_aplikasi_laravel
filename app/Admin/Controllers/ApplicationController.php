<?php

namespace App\Admin\Controllers;

use App\Models\Application;
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
        $grid->column('status', __('Status'))->display(function ($status, $column) {
            if ($this->status == 0) {
                return Application::STATUSES[0];
            } elseif ($this->status == 1) {
                return Application::STATUSES[1];
            }
        });
        $grid->column('note', __('Note'));
        $grid->column('last_update', __('Last update'));
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
        $show->field('category_id', __('Category id'));
        $show->field('whm_id', __('Whm id'));
        $show->field('url', __('Url'));
        $show->field('status', __('Status'));
        $show->field('last_update', __('Last update'));
        $show->field('note', __('Note'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

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

        $form->select('category_id', 'Category')->options(Category::all()->pluck('name', 'id'));
        $form->select('whm_id', 'WHM')->options(Whm::all()->pluck('name', 'id'));
        $form->textarea('url', __('Url'));
        $form->select('status', __('Status'))->options(Application::STATUSES);
        $form->date('last_update', __('Last update'))->default(date('Y-m-d'));
        $form->textarea('note', __('Note'));
        $form->hidden('user_id');
        $form->saving(function (Form $form) {
            $form->user_id = Auth::user()->id;
        });

        return $form;
    }
}
