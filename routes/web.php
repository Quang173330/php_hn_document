<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'localization'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::post('/follow/{id}', 'UserController@follow')->name('follow');
    Route::post('/unfollow/{id}', 'UserController@unfollow')->name('unfollow');
    Route::resource('documents', 'DocumentController', [
        'as' => 'user',
    ]);
    Route::get('upload', 'DocumentController@upload')
        ->name('user.documents.upload')->middleware('auth');
    Route::post('upload', 'DocumentController@storeUpload')
        ->name('user.documents.storeUpload')->middleware('auth');
    Route::post('search', 'DocumentController@search')->name('documents.search');
    Route::post('mark/{id}', 'DocumentController@mark')->name('documents.mark');
    Route::post('unmark/{id}', 'DocumentController@unmark')->name('documents.unmark');
    Route::post('download/{id}', 'DocumentController@download')
        ->name('documents.download')->middleware('auth');
    Route::get('/user/buycoin', 'UserController@buyCoin')
        ->name('buy-coin')->middleware('auth');
    Route::post('/payment', 'UserController@payment')
        ->name('payment')->middleware('auth');
    Route::post('comment/{id}', 'DocumentController@comment')->name('documents.comment');
    Route::resource('/admin/categories', 'CategoryController', [
        'as' => 'admin',
    ]);
    Route::get('admin', 'AdminController@index')->name('admin.home');
    Route::resource('/admin/members', 'MemberController', [
        'as' => 'admin',
    ]);
    Route::post('admin/members/ban/{id}', 'MemberController@ban')->name('admin.members.ban');
    Route::post('admin/members/upgrade/{id}', 'MemberController@upgrade')->name('admin.members.upgrade');
});

Route::get('change-language/{locale}', 'HomeController@changeLanguage')->name('change-language');
