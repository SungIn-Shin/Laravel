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


Route::get('/', 'HomeController@index')->name('home');



Auth::routes();


Route::group(['prefix' => 'iheart'], function (){

    Route::get('dashboard', function(){
        return view('iheart.dashboard');
    })->name('iheart.dashboard');

    Route::get('regist', function() {
        return view('iheart.regist');
    })->name('ihart.regist');

    Route::post('regist', 'DocumentController@store')->name('iheart.document.regist');

    Route::get('list', 'DocumentController@index')->name('iheart.document.list');

    Route::group(['prefix' => 'employee', 'middleware' => ['role:employee']], function() {
        
    });
});







// 관리자 예제
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|team_leader|salse_dept_leader|support_leader|nomal']], function (){
    Route::get('dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // 사용자 리스트 조회
    Route::get('/user/list', 'AdminController@showUserListForm')->name('admin.user.list');

    // 사용자 상세 조회
    Route::get('/user/{user_id}', 'AdminController@showUserDetailForm')->name('admin.user.detail');

    // 사용자 정보 수정
    Route::post('/user/update', 'AdminController@updateUser')->name('admin.user.update');

    Route::get('admin/user/registForm', function() {
        return view('admin.user.regist');
    });

    Route::post('/user/regist', 'AdminController@regist');
});