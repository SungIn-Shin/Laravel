<?php
use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamLeaderUserToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
        // 팀장 계정 삽입
        $team_leader = [  'name'  => 'team_leader', 
                    'email' => 'team_leader@i-heart.co.kr', 
                    'password' => bcrypt('team_leader')
                 ];        
        User::create($team_leader);        

        // 팀장 권한 추가        
        $team_leader_role = new Role;
        $team_leader_role->name         = 'team_leader';
        $team_leader_role->display_name = '팀장'; // optional
        // Allow a user to...
        $team_leader_role->description  = '팀장 권한'; // optional
        $team_leader_role->save();
        
        // 팀장 => 팀장 권한 부여
        $role_user = new RoleUser;
        $role_user->user_id = 3;
        $role_user->role_id = 3;
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
