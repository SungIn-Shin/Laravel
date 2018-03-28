<?php
use App\Team;
use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalseLeaderUserToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 사업팀장 삽입
        $salse_leader = new User([   'name'  => 'salse_leader',
                                    'email' => 'salse_leader@i-heart.co.kr', 
                                    'password' => bcrypt('salse_leader'), 
                                    'position_id' => 3,
                                    'position_name' => '부장', 
                                    'job_id' => 3,
                                    'job_name' => '사업부장'
        ]);        
        $salse_team = Team::find(3);
        $salse_team->users()->save($salse_leader);

        // 사업부장 권한 추가        
        $salse_leader_role = new Role;
        $salse_leader_role->name         = 'salse_leader';
        $salse_leader_role->display_name = '사업부장'; // optional
        // Allow a user to...
        $salse_leader_role->description  = '사업부장 권한'; // optional
        $salse_leader_role->save();
        
        // 사업부장 => 사업부장 권한 부여
        $role_user = new RoleUser;
        $role_user->user_id = 7;
        $role_user->role_id = 4;
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
