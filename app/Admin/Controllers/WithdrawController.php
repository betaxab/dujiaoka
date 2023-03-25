<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Withdraw;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Withdraw as WithdrawModel;

class WithdrawController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Withdraw(['user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('user.email', admin_trans('user.fields.email'));
            $grid->column('amount');
            $grid->column('type')->using(WithdrawModel::getWithdrawalTypeMap())
                ->label([
                    WithdrawModel::WITHDRWAL_TYPE_TO_BALANCE => Admin::color()->primary(),
                    WithdrawModel::WITHDRWAL_TYPE_TO_ACCOUNT => Admin::color()->success(),
                ]);
            $grid->column('withdrawal_method')->select(WithdrawModel::getWithdrawalMethodMap());
            $grid->column('withdraw_account')->copyable();
            $grid->column('status')->select(WithdrawModel::getWithdrawalStatusMap())->sortable();
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $users = User::query()->pluck('email', 'id');
                $filter->equal('id');
                $filter->equal('user_id')->select($users);
                $filter->equal('type')->select(WithdrawModel::getWithdrawalTypeMap());
                $filter->equal('status')->select(WithdrawModel::getWithdrawalStatusMap());
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
        return Show::make($id, new Withdraw(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('user.email', admin_trans('user.fields.email'));
            $show->field('amount');
            $show->field('type')->using(WithdrawModel::getWithdrawalTypeMap());
            $show->field('withdrawal_method')->using(WithdrawModel::getWithdrawalMethodMap());
            $show->field('withdraw_account');
            $show->field('status')->using(WithdrawModel::getWithdrawalStatusMap());
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
        return Form::make(new Withdraw(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('amount');
            $form->radio('type')->options(WithdrawModel::getWithdrawalTypeMap());
            $form->radio('withdrawal_method')->options(WithdrawModel::getWithdrawalMethodMap());
            $form->text('withdraw_account');
            $form->radio('status')->options(WithdrawModel::getWithdrawalStatusMap());
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
