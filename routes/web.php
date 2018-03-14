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

    // 일반 사원
    Route::group(['prefix' => 'employee', 'middleware' => ['role:employee']], function() {
        Route::get('regist', function() {
            return view('iheart.employee.regist');
        })->name('ihart.employee.regist');
    
        Route::post('regist', 'DocumentController@store')->name('iheart.employee.regist');
    
        Route::get('list', 'DocumentController@index')->name('iheart.employee.list');
    
        Route::get('detail/{document_id}', 'DocumentController@detail')->name('iheart.employee.detail');
    });

    // 팀장
    Route::group(['prefix' => 'team_leader', 'middleware' => ['role:team_leader']], function() {
        Route::get('regist', function() {
            return view('iheart.team_leader.regist');
        })->name('ihart.team_leader.regist');
    
        Route::post('regist', 'DocumentController@store')->name('iheart.team_leader.regist');
    
        Route::get('list', 'DocumentController@teamLeaderIndex')->name('iheart.team_leader.list');
    
        Route::get('detail/{document_id}', 'DocumentController@teamLeaderDetail')->name('iheart.team_leader.detail');
        // 반려 처리
        Route::post('reject', 'DocumentController@teamLeaderReject')->name('iheart.team_leader.reject');
        // 승인 처리
        Route::post('apr', 'DocumentController@teamLeaderApr')->name('iheart.team_leader.apr');
    });

    // 경영지원 팀장
    Route::group(['prefix' => 'support_leader', 'middleware' => ['role:support_leader']], function() {
        Route::get('regist', function() {
            return view('iheart.support_leader.regist');
        })->name('ihart.support_leader.regist');
    
        Route::post('regist', 'DocumentController@store')->name('iheart.support_leader.regist');
    
        Route::get('list', 'DocumentController@supportLeaderIndex')->name('iheart.support_leader.list');
    
        Route::get('detail/{document_id}', 'DocumentController@supportLeaderDetail')->name('iheart.support_leader.detail');
        // 반려 처리
        Route::post('reject', 'DocumentController@supportLeaderReject')->name('iheart.support_leader.reject');
        // 승인 처리
        Route::post('apr', 'DocumentController@supportLeaderApr')->name('iheart.support_leader.apr');
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