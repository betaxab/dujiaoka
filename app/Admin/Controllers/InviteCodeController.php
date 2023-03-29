<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\InviteCode;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\InviteCode as InviteCodeModel;

class InviteCodeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new InviteCode(['user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('user.email', admin_trans('invite-code.fields.user_email'));
            $grid->column('code', admin_trans('invite-code.fields.invite_code'));
            $grid->column('created_at')->sortable();
            $grid->model()->orderByDesc('id');

            $grid->filter(function (Grid\Filter $filter) {
                $users = User::query()->pluck('email', 'id');
                $filter->equal('id');
                $filter->equal('user_id', admin_trans('invite-code.fields.user_email'))->select($users);
                $filter->equal('code', admin_trans('invite-code.fields.invite_code'));
                $filter->equal('status')->select(InviteCodeModel::getInviteCodeStatusMap());
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
        return Show::make($id, new InviteCode(['user']), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('user.email', admin_trans('invite-code.fields.user_email'));
            $show->field('code', admin_trans('invite-code.fields.invite_code'));
            $show->field('status')->using(InviteCodeModel::getInviteCodeStatusMap());
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
        return Form::make(new InviteCode(), function (Form $form) {
            $form->display('id');
            $form->text('user_id')->required();
            $form->text('code', admin_trans('invite-code.fields.invite_code'))->required();
            $form->text('pv')->default(0);
            $form->radio('status')->options(InviteCodeModel::getInviteCodeStatusMap())->default(InviteCodeModel::CODE_STATUS_UNUSED);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
