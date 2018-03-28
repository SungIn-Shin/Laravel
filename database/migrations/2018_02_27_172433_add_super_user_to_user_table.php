<?php
use App\Team;
use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class AddSuperUserToUserTable extends Migration
{
    use EntrustUserTrait; // add this trait to your user model
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 슈퍼 관리자 계정 삽입.
        $super_user = new User([    'name'  => 'admin', 
                                    'email' => 'admin@i-heart.co.kr', 
                                    'password' => bcrypt('admin'), 
                                    'position_id' => 1, 
                                    'position_name' => '관리자', 
                                    'job_id' => 1,
                                    'job_name' => '관리자'
                 ]);        
        $super_team = Team::find(1);
        $super_team->users()->save($super_user);

        // User::create($admin);        

        // 슈퍼관리자 권한 추가        
        $super_role = new Role;
        $super_role->name         = 'admin';
        $super_role->display_name = '슈퍼관리자'; // optional
        // Allow a user to...
        $super_role->description  = '슈퍼관리자 권한'; // optional
        $super_role->save();
        
        // 슈퍼관리자 => 슈퍼관리자 권한 부여
        $role_user = new RoleUser;
        $role_user->user_id = 1;
        $role_user->role_id = 1;
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
