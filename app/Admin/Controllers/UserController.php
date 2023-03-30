<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\User as UserModel;
use App\Models\UserGroup as UserGroupModel;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(['invite_user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('email');
            $grid->column('status')->switch()->sortable();
            $grid->column('balance')->sortable();
            $grid->column('invite_user.email', admin_trans('user.fields.invite_user_email'));
            $grid->column('last_login_ip');
            $grid->column('last_login_at')->sortable();
            $grid->column('created_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('email');
                $filter->equal('invite_user_id');
                $filter->equal('group_id')->select(UserGroupModel::query()->pluck('name', 'id'));
                $filter->like('remarks');
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('email');
            $show->field('invite_user_id');
            $show->field('telegram_id');
            $show->field('password');
            $show->field('balance');
            $show->field('discount');
            $show->field('commission_type');
            $show->field('commission_rate');
            $show->field('status');
            $show->field('last_login_ip');
            $show->field('last_login_at');
            $show->field('remarks');
            $show->field('group_id');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->email('email')->required()->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'unique:users,email';
                }
            });
            $form->text('password')->value('')->placeholder(admin_trans('user.fields.dont_change_pass_placeholder'));
            $form->decimal('balance')->required()->default(0);
            $form->text('telegram_id');
            $form->text('discount');
            $form->select('commission_type')->options(UserModel::getCommissionTypeMap());
            $form->text('commission_rate');
            $form->switch('status');
            $form->select('invite_user_id')->options(
                \App\Models\User::query()->pluck('email', 'id')
            )->default(0);
            $form->select('group_id')->options(
                UserGroupModel::query()->pluck('name', 'id')
            )->required();
            $form->textarea('remarks');
            $form->saving(function (Form $form) {
                if ($form->isEditing() && $form->password) {
                    $form->password = bcrypt($form->password);
                } elseif ($form->isCreating()) {
                    $form->password = $form->password ? bcrypt($form->password) : bcrypt(123456);
                } else {
                    $form->deleteInput('password');
                }
                if (is_null($form->username)) {
                    $form->username = $form->email;
                }
                if (is_null($form->invite_user_id)) {
                    $form->invite_user_id = 0;
                }
            });
        });
    }
}