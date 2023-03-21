<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

return [
    'labels' => [
        'SystemSetting' => '系统设置',
        'system_setting' => '系统设置',
        'base_setting' => '基本设置',
        'mail_setting' => '邮件服务',
        'order_push_setting' => '订单推送'
    ],

    'fields' => [
        'title' => '网站标题',
        'text_logo' => '文字 LOGO',
        'img_logo' => '图片 LOGO',
        'keywords' => '网站关键词',
        'description' => '网站描述',
        'notice' => '站点公告',
        'footer' => '页脚自定义代码',
        'manage_email' => '管理员邮箱',
        'is_open_anti_red' => '是否开启微信/QQ 防红',
        'is_open_img_code' => '是否开启图形验证码',
        'is_open_search_pwd' => '是否开启查询密码',
        'is_open_google_translate' => '是否开启 Google 翻译',

        'is_open_server_jiang' => '是否开启 Server 酱',
        'server_jiang_token' => 'Server 酱通讯 Token',
        'is_open_telegram_push' => '是否开启 Telegram 推送',
        'telegram_userid' => 'Telegram 用户 ID',
        'telegram_bot_token' => 'Telegram 通讯 Token',
        'is_open_bark_push' => '是否开启Bark推送',
        'is_open_bark_push_url' => '是否推送订单URL',
        'bark_server' => 'Bark服务器',
        'bark_token' => 'Bark通讯Token',
        'is_open_qywxbot_push' => '是否开启企业微信Bot推送',
        'qywxbot_key' => '企业微信Bot通讯Key',

        'template' => '站点模板',
        'language' => '站点语言',
        'order_expire_time' => '订单过期时间（分钟）',

        'driver' => '邮件驱动',
        'host' => 'SMTP 服务器地址',
        'port' => '端口',
        'username' => '账号',
        'password' => '密码',
        'encryption' => '协议',
        'from_address' => '发件地址',
        'from_name' => '发件名称',
    ],
    'options' => [
    ],
    'rule_messages' => [
        'save_system_setting_success' => '系统配置保存成功！',
        'change_reboot_php_worker' => '修改部分配置需要重启 [supervisor] 或 PHP 进程管理工具才会生效，例如邮件服务，Server 酱等。'
    ]
];
