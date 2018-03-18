<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace'=>'App\Http\Controllers\Api',
    'middleware' => 'serializer:array',
], function ($api){
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ],function ($api){
        // 图片验证码
        $api->get('captchas', 'CaptchasController@store')->name('api.captchas.store');
        // 用户注册
        $api->post('users', 'UserController@store')->name('api.users.store');
        // 登录
        $api->post('authorizations','AuthorizationsController@store')->name('api.authorizations.store');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')->name('api.authorizations.destroy');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
        // 游客可以访问的接口
        // 轮播图
        $api->get('carousel_figure', 'ImagesController@carousel_figure')->name('api.image.carousel_figure');
        // 宿舍号
        $api->get('dormitories', 'DormitoriesController@index')->name('api.dormitories.index');
        // 文章列表 ?include=user
        $api->get('topics', 'TopicController@index')->name('api.topic.index');
        // 文章详情 ?include=user
        $api->get('topics/{topic}', 'TopicController@show')->name('api.topics.show');
        // 分类列表
        $api->get('categories', 'CategoriesController@index')->name('api.categories.index');
        // 某个分类下的文章(用电常识、停电公告, 故障报修除外)
        $api->get('categories/{category}', 'CategoriesController@show')->name('api.categories.show');

        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 当前登录用户信息 ?include=dormitory
            $api->get('user', 'UserController@me')->name('api.user.show');
            // 发布文章
            $api->post('topics', 'TopicController@store')->name('api.topic.store');
            // 故障报修
            $api->post('faults', 'FaultsController@store')->name('api.fault.store');
            // 投诉举报
            $api->post('reports', 'ReportsController@store')->name('api.reports.store');
            // 通知列表
            $api->get('user/notifications', 'NotificationsController@index')->name('api.user.notifications.index');
        });
    });
});
