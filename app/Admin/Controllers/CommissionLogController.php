<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CommissionLog;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\CommissionLog as CommissionLogModel;

class CommissionLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CommissionLog(['user', 'order']), function (Grid $grid) {
            $grid->column('order_id');
            $grid->column('order.title', admin_trans('order.fields.title'));
            $grid->column('user.email', admin_trans('user.fields.invite_user_email'));
            $grid->column('status')->select(CommissionLogModel::getCommissionStatusMap());
            $grid->column('amount')->sortable();
            $grid->column('order.email', admin_trans('order.fields.email'));
            $grid->column('created_at')->sortable();
            $grid->model()->orderByDesc('id');

            $grid->filter(function (Grid\Filter $filter) {
                $users = User::query()->pluck('email', 'id');
                $filter->equal('id');
                $filter->equal('user_id')->select($users);
                $filter->equal('order_id');
                $filter->equal('status')->select(CommissionLogModel::getCommissionStatusMap());
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new CommissionLog(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('order_id');
            $show->field('status');
            $show->field('amount');
            $show->field('withdraw_id');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CommissionLog(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('order_id');
            $form->text('status');
            $form->text('amount');
            $form->text('withdraw_id');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
