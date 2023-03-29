<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Emailtpl;
use App\Jobs\MailSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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

    public function sendMailVerification(Request $request)
    {
        $email = $request->post('email');
        $ip = $request->ip();
        // 检查缓存
        if (Cache::has('REGISTER_IP_RATE_LIMIT_'.md5($ip))) {
            return response()->json(['code' => 0, 'message' => __('dujiaoka.send-code.ip_rate_limit_err')]);
        }
        if (Cache::get('LAST_SEND_EMAIL_CODE_TIMESTAMP_'.md5($email))) {
            return response()->json(['code' => 0, 'message' => __('dujiaoka.send-code.code_sent_err_message')]);
        }

        // 设置缓存，单 IP 60 秒限制
        Cache::put('REGISTER_IP_RATE_LIMIT_'.md5($ip), $ip, 60);

        if (User::query()->where('email', $email)->exists()){
            return response()->json(['code' => 0, 'message' => __('dujiaoka.send-code.email_already_exists')]);
        }

        $code = random_int(100000, 999999);

        $sysCache = cache('system-setting');
        $param = [
            'created_at' => date('Y-m-d H:i'),
            'webname' => $sysCache['text_logo'] ?? '独角数卡',
            'weburl' => config('app.url'),
            'code' => $code,
        ];
        $mailtpl = Emailtpl::query()->where('tpl_token', 'email_verification')->first()->toArray();
        $info = replace_mail_tpl($mailtpl, $param);
        MailSend::dispatch($email, $info['tpl_name'], $info['tpl_content']);

        // 设置缓存
        // 单邮箱验证码 300 秒有效
        Cache::put('EMAIL_VERIFICATION_CODE_'.md5($email), $code, 300);
        // 单邮箱时间戳 60 秒限制
        Cache::put('LAST_SEND_EMAIL_CODE_TIMESTAMP_'.md5($email), time(), 60);

        return response()->json(['code' => 1, 'message' => __('dujiaoka.send-code.sent_successfully')]);
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