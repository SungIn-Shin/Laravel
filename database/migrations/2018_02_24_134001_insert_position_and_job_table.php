<?php


use App\Position;
use App\Job;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPositionAndJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $posArr = array("관리자", "사장", "부장", "차장", "과장", "대리", "사원");

        for ($i = 0; $i < sizeof($posArr); $i++)
        {
            $position = new Position;
            $position->name = $posArr[$i];
            $position->sortkey = $i + 1;
            $position->save();
        }
        
        $jobArr = array('관리자', 'CEO', '사업부장', '팀장');
        for ($i = 0; $i < sizeof($jobArr); $i++) 
        {
            $job = new Job;
            $job->name = $jobArr[$i];
            $job->sortkey = $i + 1;
            $job->save();
        }
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
