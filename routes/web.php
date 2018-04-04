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


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('index');



Auth::routes();


Route::group(['prefix' => 'iheart'], function (){

    // Route::get('dashboard', function(){
    //     return view('iheart.dashboard');
    // })->name('iheart.dashboard');

    // 슈퍼 관리자
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        // 슈퍼관리자 팀 관리
        Route::group(['prefix' => 'teams'], function () {
            // 팀 등록 폼
            Route::get('regist',            'TeamController@registForm')->name('iheart.admin.teams.registForm');
            // 팀 등록
            Route::post('regist',           'TeamController@regist')->name('iheart.admin.teams.regist');
            // 팀 전체 조회            
            Route::get('show',              'TeamController@show')->name('iheart.admin.teams.show');
            // 팀 정렬 수정
            Route::post('update/sort',      'TeamController@updateSort')->name('iheart.admin.teams.update.sort');
        });

        // 슈퍼관리자 사용자 관리
        Route::group(['prefix' => 'users'], function () {
            // 자용자 등록 폼
            Route::get('regist',            'UserController@userRegistForm')->name('iheart.admin.users.registForm');
            // 사용자 등록
            Route::post('regist',           'UserController@userRegist')->name('iheart.admin.users.regist');
            // 사용자 리스트 조회
            Route::get('show',              'UserController@showUsers')->name('iheart.admin.users.show');
            // 사용자 정보 상세보기
            Route::get('detail/{user_id}',  'UserController@detailUser')->name('iheart.admin.users.detail');
            // 사용자 정보 수정
            Route::post('update',           'UserController@updateUser')->name('iheart.admin.users.update');
        });

    });

    // 일반 사원
    Route::group(['prefix' => 'employee', 'middleware' => ['role:employee']], function() {
        Route::get('regist',                'DocumentController@registForm')->name('ihart.employee.regist');
    
        Route::post('regist',               'DocumentController@insertDocument')->name('iheart.employee.regist');
    
        Route::get('list',                  'DocumentController@selectNomalUserDocumentsList')->name('iheart.employee.list');
    
        Route::get('detail/{document_id}',  'DocumentController@documentDetail')->name('iheart.employee.detail');
    });
    
    // 팀장
    Route::group(['prefix' => 'team_leader', 'middleware' => ['role:team_leader']], function() {
        Route::get('regist',                'DocumentController@registForm')->name('ihart.team_leader.regist');
    
        Route::post('regist',               'DocumentController@insertDocument')->name('iheart.team_leader.regist');
    
        Route::get('list',                  'DocumentController@selectTeamLeaderDocumentsList')->name('iheart.team_leader.list');
    
        Route::get('detail/{document_id}',  'DocumentController@documentDetail')->name('iheart.team_leader.detail');
        // 반려 처리
        Route::post('reject',               'DocumentController@teamLeaderReject')->name('iheart.team_leader.reject');
        // 승인 처리
        Route::post('apr',                  'DocumentController@teamLeaderApr')->name('iheart.team_leader.apr');
    });

    // 경영지원 팀장
    Route::group(['prefix' => 'support_leader', 'middleware' => ['role:support_leader']], function() {
        Route::get('regist', function() {
            return view('iheart.support_leader.regist');
        })->name('ihart.support_leader.regist');
    
        Route::post('regist',               'DocumentController@insertDocument')->name('iheart.support_leader.regist');
    
        Route::get('list',                  'DocumentController@selectSupportLeaderDocumentsList')->name('iheart.support_leader.list');
    
        Route::get('detail/{document_id}',  'DocumentController@documentDetail')->name('iheart.support_leader.detail');
        // 반려 처리
        Route::post('reject',               'DocumentController@supportLeaderReject')->name('iheart.support_leader.reject');
        // 승인 처리
        Route::post('apr',                  'DocumentController@supportLeaderApr')->name('iheart.support_leader.apr');
    });
});







// // 관리자 예제
// Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|team_leader|salse_dept_leader|support_leader|nomal']], function (){
//     Route::get('dashboard', function() {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');

//     // 사용자 리스트 조회
//     Route::get('/user/list', 'AdminController@showUserListForm')->name('admin.user.list');

//     // 사용자 상세 조회
//     Route::get('/user/{user_id}', 'AdminController@showUserDetailForm')->name('admin.user.detail');

//     // 사용자 정보 수정
//     Route::post('/user/update', 'AdminController@updateUser')->name('admin.user.update');

//     Route::get('admin/user/registForm', function() {
//         return view('admin.user.regist');
//     });

<<<<<<< HEAD
    Route::post('/user/regist', 'AdminController@regist');
});


// 패스워드 만료일 (2018.03.30 KKW)
Route::get('password/expired', 'Auth\ExpiredPasswordController@expired')->name('password.expired')->middleware('auth');
Route::post('password/post_expired', 'Auth\ExpiredPasswordController@postExpired')->name('password.post_expired')->middleware('auth');
=======
//     Route::post('/user/regist', 'AdminController@regist');
// });
>>>>>>> c9522f385d8103ef3f4bf0835ee611f3aa1fb923
