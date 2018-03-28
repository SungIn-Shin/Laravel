<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // 문서 반려 코멘트 테이블
        Schema::create('approval_lines', function(Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('document_id')->unsigned();     // documents ID (FK)
            $table->integer('user_id');
            $table->string('status');
            $table->integer('sortkey');
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('approval_lines');
    }
}
