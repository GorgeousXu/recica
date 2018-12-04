<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/** 数据库测试 */
Route::get('data', '\App\Http\Controllers\IndexController@databaseUsage');

/** 重点页面 */
Route::get('waterfall', '\App\Http\Controllers\HtmlController@waterfall');
Route::get('ajax_waterfall', '\App\Http\Controllers\HtmlController@ajax_waterfall');

Route::get('canvas','\App\Http\Controllers\HtmlController@canvas');

Route::get('turntable','\App\Http\Controllers\HtmlController@turntable');
Route::post('ajax_turntable','\App\Http\Controllers\HtmlController@ajax_turntable');

Route::get('video','\App\Http\Controllers\HtmlController@video');

Route::get('music','\App\Http\Controllers\HtmlController@music');