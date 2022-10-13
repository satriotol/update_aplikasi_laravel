<?php

namespace App\Admin\Controllers;

use App\Models\ApplicationStatus;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class ApplicationStatusController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ApplicationStatus';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ApplicationStatus());

        $grid->column('id', __('Id'));
        $grid->column('status', __('Status'));
        $grid->column('application_id', __('Application id'));
        $grid->column('last_updated', __('Last updated'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(ApplicationStatus::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('status', __('Status'));
        $show->field('application_id', __('Application id'));
        $show->field('last_updated', __('Last updated'));
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
        $form = new Form(new ApplicationStatus());

        $form->select('status', __('Status'))->options(ApplicationStatus::STATUSES)->rules('required');
        $form->text('application_id', __('Application id'));
        $form->date('last_updated', __('Last updated'))->default(date('Y-m-d'));

        return $form;
    }
}
