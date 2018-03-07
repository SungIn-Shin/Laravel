<?php
use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupportLeaderUserToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 경영지원팀장 계정 삽입
        $support_leader = [  'name'  => 'support_leader', 
                    'email' => 'support_leader@i-heart.co.kr', 
                    'password' => bcrypt('support_leader')
                 ];        
        User::create($support_leader);        

        // 경영지원팀장 권한 추가        
        $support_leader_role = new Role;
        $support_leader_role->name         = 'support_leader';
        $support_leader_role->display_name = '경영지원팀장'; // optional
        // Allow a user to...
        $support_leader_role->description  = '경영지원팀장 권한'; // optional
        $support_leader_role->save();
        
        // 경영지원팀장 => 경영지원팀장 권한 부여
        $role_user = new RoleUser;
        $role_user->user_id = 5;
        $role_user->role_id = 5;
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
