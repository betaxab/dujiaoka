<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['dujiaoka.boot'],'namespace' => 'Home'], function () {
    // 首页
    Route::get('/', 'HomeController@index');
    // 商品详情
    Route::get('buy/{id}', 'HomeController@buy');
    // 提交订单
    Route::post('create-order', 'OrderController@createOrder');
    // 结算页
    Route::get('bill/{orderSN}', 'OrderController@bill');
    // 通过订单号详情页
    Route::get('detail-order-sn/{orderSN}', 'OrderController@detailOrderSN');
    // 订单查询页
    Route::get('order-search', 'OrderController@orderSearch');
    // 检查订单状态
    Route::get('check-order-status/{orderSN}', 'OrderController@checkOrderStatus');
    // 通过订单号查询
    Route::post('search-order-by-sn', 'OrderController@searchOrderBySN');
    // 通过邮箱查询
    Route::post('search-order-by-email', 'OrderController@searchOrderByEmail');
    // 通过浏览器查询
    Route::post('search-order-by-browser', 'OrderController@searchOrderByBrowser');
});

Route::group(['middleware' => ['dujiaoka.boot'],'namespace' => 'Auth'], function () {
    // 登录
    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@loginHandler');
    // 退出登录
    Route::get('/logout', 'AuthController@logout');
    // 发送验证码
    Route::post('/send/mailverification', 'AuthController@sendMailVerification');
});

Route::group(['middleware' => 'auth:web','namespace' => 'User'], function () {
    // 用户中心首页
    Route::get('/user', 'UserController@index');
});

Route::group(['middleware' => ['install.check'],'namespace' => 'Home'], function () {
    // 安装
    Route::get('install', 'HomeController@install');
    // 执行安装
    Route::post('do-install', 'HomeController@doInstall');
});

