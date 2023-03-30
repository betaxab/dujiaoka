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
            <form id="login" action="{{ url('register') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.register_email') }}</div>
                    <input type="email" name="email" class="form-control" placeholder="{{ __('hyper.register_email_placeholder') }}">
                </div>
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.register_verification_code') }}</div>
                    <div class="input-group">
                        <input type="text" name="email_verification_code" class="form-control" placeholder="{{ __('hyper.register_verification_code_placeholder') }}">
                        <button class="btn btn-outline-primary" type="button" id="send_code">{{ __('hyper.register_send_code') }}</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.register_password') }}</div>
                    <input type="password" name="password" class="form-control" placeholder="{{ __('hyper.register_password_placeholder') }}">
                </div>
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.register_password2') }}</div>
                    <input type="password" name="password2" class="form-control" placeholder="{{ __('hyper.register_password2_placeholder') }}">
                </div>
                <div class="form-group">
                    <div class="buy-title">{{ __('hyper.register_invite_code') }}</div>
                    <input type="text" name="invite_code" class="form-control" placeholder="{{ __('hyper.register_invite_code_placeholder') }}">
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary" id="submit">
                        <i class="mdi mdi-login mr-1"></i>
                        {{ __('hyper.register_register_now') }}
                    </button>
                </div>
            </form>
            <div class="mt-3 text-center">
                {{ __('hyper.register_have_account') }} <a href="{{ url('login') }}">{{ __('hyper.register_back_to_login') }}</a>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')

<script>
    var num = 60;
    function timeoutChangeStyle() {
        $('#send_code').disabled = true;
        if (num == 0) {
            $('#send_code').text("{{ __('hyper.register_send_code') }}");
            num = 60;
            $('#send_code').disabled = false;
        } else {
            var str = num + "{{ __('hyper.register_send_code_wait') }}";
            $('#send_code').text(str);
            setTimeout("timeoutChangeStyle()", 1000);
        }
        num--;
    }
    if (getCookie('invitecode') != '') {
        $("input[name='invite_code']").val(getCookie('invitecode'));
    }
    $('#send_code').click(function () {
        $.post("/send/mailverification", {
            _token: "{{ csrf_token() }}",
            email: $("input[name='email']").val(),
        }, function (res) {
            if (res.code) {
                $.NotificationApp.send("{{ __('hyper.success') }}", "{{ __('hyper.register_sent_successfully') }}","top-center","rgba(0,0,0,0.2)","success");
                timeoutChangeStyle();
            } else {
                $.NotificationApp.send("{{ __('hyper.buy_warning') }}",res.message,"top-center","rgba(0,0,0,0.2)","info");
            }
        })
    });
    $('#submit').click(function(){
        var email = $("input[name='email']").val();
        if(email == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.register_email_empty') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        let reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
        if (!reg.test(email)) {
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.register_email_error') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        if($("input[name='email_verification_code']").val() == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.register_verification_code_empty') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        var password = $("input[name='password']").val();
        var password2 = $("input[name='password2']").val();
        if(password == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.register_password_empty') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        if(password2 == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.register_password2_empty') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        if (password != password2){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.register_password_doesnt_match') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
    });
</script>
@stop
