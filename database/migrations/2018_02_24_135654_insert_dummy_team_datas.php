<?php
use App\Team;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDummyTeamDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $team0 = new Team;
        $team0->name = '관리자';
        $team0->location = 'In the Sky';
        $team0->save();

        $team1 = new Team;
        $team1->name = '경영지원팀';
        $team1->location = '본사';
        $team1->save();

        $team2 = new Team;
        $team2->name = '영업팀';
        $team2->location = '본사';
        $team2->save();

        $team3 = new Team;
        $team3->name = '개발팀';
        $team3->location = '본사';
        $team3->save();

        $team4 = new Team;
        $team4->name = 'IDC운영팀';
        $team4->location = '성남';
        $team4->save();

        $team1 = new Team;
        $team1->name = '기술운영팀';
        $team1->location = '본사';
        $team1->save();
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
