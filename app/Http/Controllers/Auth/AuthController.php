<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login()
    {
        return $this->render('static_pages/login');
    }

    /**
     * 登录
     *
     * @param Request $request
     *
     */
    public function loginHandler(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::query()->where('email', $credentials['email'])->first();
        if (!$user){
            return $this->err(__('dujiaoka.login.email_does_not_exist'));
        }
        if ($user->status === 0){
            return $this->err(__('dujiaoka.login.user_has_been_banned'));
        }

        if (Auth::attempt($credentials, true)) {
            $user->last_login_ip = $request->ip();
            $user->last_login_at = now()->toDateTimeString();
            $user->save();

            return redirect()->intended('/user');
        }

        return $this->err(__('dujiaoka.login.login_info_error'));
    }

    /**
     * 退出登录
     *
     * @param Request $request
     *
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->to('/');
    }
}