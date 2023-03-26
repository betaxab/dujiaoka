@extends('hyper.layouts.default')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="page-title-box">
            {{-- 标题 --}}
            <h4 class="page-title text-center">{{ dujiaoka_config_get('title') }}</h4>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card card-body sticky">
            <form id="login" action="{{ url('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.login_email') }}</div>
                    <input type="email" name="email" class="form-control" placeholder="{{ __('hyper.login_email_placeholder') }}">
                </div>
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.login_password') }}</div>
                    <input type="password" name="password" class="form-control" placeholder="{{ __('hyper.login_password_placeholder') }}">
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary" id="submit">
                        <i class="mdi mdi-login mr-1"></i>
                        {{ __('hyper.login_login') }}
                    </button>
                </div>
            </form>
            <div class="mt-3 text-center">
                {{ __('hyper.register_account_tip') }}<a href="{{ url('register') }}">{{ __('hyper.login_register') }}</a>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $('#submit').click(function(){
        var email = $("input[name='email']").val();
        if(email == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('dujiaoka.login.email_does_not_exist') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        let reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
        if (!reg.test(email)) {
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.login_email_error') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        var password = $("input[name='password']").val();
        if(password == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.login_password_empty') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
    });
</script>
@stop
