<?php

use Illuminate\Database\Seeder;

use App\ExpenditureItem;

use App\Rank;
use App\Position;
use App\Role;
use App\Team;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 팀 추가 
        $this->addTeam();
        // 직급, 직책 추가
        $this->addRankAndPosition();
        // 권한 추가
        $this->addRoles();
        // 사용자 추가 및 권한부여
        $this->addUserAndAttachRole();
        // $this->call(UsersTableSeeder::class);
        // Aditure_items 테이블 seed data insert

        $list = array();
        $codes = array(811, 812, 813, 814, 824, 825, 826, 830, 831);
        $names = array('복리후생비', '여비교통비', '접대비', '통신비', '운반비', '교육훈련비', '도서인쇄비', '소모품비', '지급수수료(기타)');
        $descs = array('식대 및 회식(회의비)', '교통비 지원금 / 법인차량 주유', '고객사 접대비', '휴대폰 지원금', '택배비/퀵비용', '교육비 지원', '도서구매' , '사무용품', '상기 항목에 아닌 기타비용');
        for($i = 0; $i < count($codes); $i++) {
            $item = new ExpenditureItem;
            $item->code = $codes[$i];
            $item->name = $names[$i];
            $item->desc = $names[$i];
            $item->save();
        }
    }

    public function addUserAndAttachRole()
    {
        // 슈퍼 관리자 계정 삽입.
        $super_user = new User([    'name'  => 'admin', 
                                    'email' => 'admin@i-heart.co.kr', 
                                    'password' => bcrypt('admin'), 
                                    'rank_id' => 1, 
                                    'rank_name' => '관리자', 
                                    'position_id' => 1,
                                    'position_name' => '관리자'
                 ]);        
        
        $super_team = Team::where('name', '관리자')->first();
        $super_user->team_id = $super_team->id;
        $super_user->save();

        $super_user->attachRole(1);

        // 일반사용자 개발팀 4명 추가
        for ($i = 1; $i <= 4; $i++) {
            $nomal_user = new User([    'name'  => 'employee'.$i,
            'email' => 'employee'.$i.'@i-heart.co.kr', 
            'password' => bcrypt('employee'.$i),
            'rank_id' => 7, 
            'rank_name' => "사원", 
            ]);        
            $nomal_team = Team::where('name', '개발팀')->first();
            $nomal_user->team_id = $nomal_team->id;
            $nomal_user->save();

            $nomal_user->attachRole(2);
        }

        // 개발 팀장 계정 삽입           
        $team_leader = new User([   'name'  => 'team_leader',
                                    'email' => 'team_leader@i-heart.co.kr', 
                                    'password' => bcrypt('team_leader'), 
                                    'rank_id' => 4,
                                    'rank_name' => '차장', 
                                    'position_id' => 4, 
                                    'position_name' => '팀장'
        ]);        
        $dev_team = Team::where('name', '개발팀')->first();
        $team_leader->team_id = $dev_team->id;
        $team_leader->save();
        $team_leader->attachRole(3);


        // 경영지원팀장 계정 삽입
        $support_leader = new User([   'name'  => 'support_leader',
                                    'email' => 'support_leader@i-heart.co.kr', 
                                    'password' => bcrypt('support_leader'), 
                                    'rank_id' => 4,
                                    'rank_name' => '차장', 
                                    'position_id' => 4, 
                                    'position_name' => '팀장'
        ]);        
        $support_team = Team::where('name', '경영지원팀')->first();
        $support_leader->team_id = $support_team->id;
        $support_leader->save();
        $support_leader->attachRole(3);
    }


    public function addRankAndPosition() 
    {
        // 1. Ranks : 직급, Position : 직책 테이블 Seeder
        $rankArr = array("관리자", "사장", "부장", "차장", "과장", "대리", "사원");

        for ($i = 0; $i < sizeof($rankArr); $i++)
        {
            $rank = new Rank;
            $rank->name = $rankArr[$i];
            $rank->sortkey = $i + 1;
            $rank->save();
        }
        
        $positionArr = array('관리자', 'CEO', '사업부장', '팀장');
        for ($i = 0; $i < sizeof($positionArr); $i++) 
        {
            $position = new Position;
            $position->name = $positionArr[$i];
            $position->sortkey = $i + 1;
            $position->save();
        }
    }

    public function addTeam() 
    {
         // 2. Teams : 팀 테이블 Seeder
         $teamNameArr = array('관리자', '경영지원팀',    '영업팀',   '개발팀',   'IDC운영팀', '기술운영팀');
         $locationArr = array('본사',   '본사',         '본사',     '본사',     '성남',      '본사');
         for ($i = 0; $i < sizeof($teamNameArr); $i++) {
             $team = new Team;
             $team->name = $teamNameArr[$i];
             $team->location = $locationArr[$i];
             $team->save();
         }
    }

    public function addRoles() 
    {
        // 슈퍼관리자 권한 추가        
        $super_role = new Role;
        $super_role->name         = 'admin';
        $super_role->display_name = '슈퍼관리자'; // optional
        $super_role->description  = '슈퍼관리자 권한'; // optional
        $super_role->save();

        // 일반 사용자 권한 추가        
        $nomal_role = new Role;
        $nomal_role->name         = 'employee';
        $nomal_role->display_name = '일반사용자'; // optional
        $nomal_role->description  = '일반사용자 권한'; // optional
        $nomal_role->save();

        // 팀장 권한 추가        
        $team_leader_role = new Role;
        $team_leader_role->name         = 'team_leader';
        $team_leader_role->display_name = '팀장'; // optional
        // Allow a user to...
        $team_leader_role->description  = '팀장 권한'; // optional
        $team_leader_role->save();

        // 사업부장 권한 추가        
        $salse_leader_role = new Role;
        $salse_leader_role->name         = 'salse_leader';
        $salse_leader_role->display_name = '사업부장'; // optional
        // Allow a user to...
        $salse_leader_role->description  = '사업부장 권한'; // optional
        $salse_leader_role->save();

         // 경영지원팀장 권한 추가        
         $support_leader_role = new Role;
         $support_leader_role->name         = 'support_leader';
         $support_leader_role->display_name = '경영지원팀장'; // optional
         // Allow a user to...
         $support_leader_role->description  = '경영지원팀장 권한'; // optional
         $support_leader_role->save();
    }
}
