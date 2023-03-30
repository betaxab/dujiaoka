<?php
return [
    'labels' => [
        'User' => '用户管理',
        'user' => '用户管理',
    ],
    'fields' => [
        'email' => '邮箱',
        'password' => '密码',
        'invite_user_email' => '邀请人邮箱',
        'telegram_id' => 'Telegram ID',
        'balance' => '余额',
        'discount' => '专享折扣比例',
        'commission_type' => '推荐返利类型',
        'commission_rate' => '推荐返利比例',
        'last_login_ip' => '登录 IP',
        'last_login_at' => '登录时间',
        'status' => '状态',
        'invite_user_id' => '邀请人 ID',
        'group_id' => '用户组',
        'remarks' => '备注',
        'dont_change_pass_placeholder' => '留空表示不修改密码',
        'invite_code' => '邀请码'
    ],
    'options' => [
        'commission_system' => '跟随系统',
        'commission_onetime' => '首次返利',
        'commission_cycle' => '循环返利',
    ],
];
