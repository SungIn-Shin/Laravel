<?php

use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNomalUserToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // 일반 사용자 계정 삽입
        $nomal = [  'name'  => 'employee', 
                    'email' => 'employee@i-heart.co.kr', 
                    'password' => bcrypt('employee')
                 ];        
        User::create($nomal);        

        // 일반 사용자 권한 추가        
        $nomal_role = new Role;
        $nomal_role->name         = 'employee';
        $nomal_role->display_name = '일반사용자'; // optional
        // Allow a user to...
        $nomal_role->description  = '일반사용자 권한'; // optional
        $nomal_role->save();
        
        // 일반 사용자 => 일반 사용자 권한 부여
        $role_user = new RoleUser;
        $role_user->user_id = 2;
        $role_user->role_id = 2;
        $role_user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
