<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/topics',  function (Request $request) {
    // 从数据库从查询话题的 id, name. 包含name的关键字
    // http://zhihu.me/api/topics?q=laravel
    // 返回包含 "laravel" 的所有数据
    $topics = \App\Topic::select(['id','name'])
        ->where('name', 'like','%'.$request->query('q').'%')
        ->get();
    return $topics;
})->middleware('api');