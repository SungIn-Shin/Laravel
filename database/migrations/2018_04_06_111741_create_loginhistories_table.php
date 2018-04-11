<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginhistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loginhistories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('useremail');
            $table->string('ip');
            $table->string('gubun'); // 로그인 구분 (U:사용자)
            $table->string('successyn'); // 성공실패 (Y:성공, N:실패)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loginhistories');
    }
}
