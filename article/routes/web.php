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

Auth::routes();

Route::get('/home', 'HomeController@index');

// 文章首页
Route::get('/article', 'ArticleController@index');
Route::get('/article/index', 'ArticleController@index');
// 添加文章
Route::any('/article/add', 'ArticleController@add');
// 修改文章
Route::any('/article/update/{id}', 'ArticleController@update');
// 删除文章
Route::any('/article/del/{id}', 'ArticleController@delete');