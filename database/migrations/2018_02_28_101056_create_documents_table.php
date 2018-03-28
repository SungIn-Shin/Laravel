<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // 문서 테이블 (지출품의서 등등...)
        Schema::create('documents', function (Blueprint $table) 
        {
            $table->increments('id');                        // pk
            $table->integer('user_id')->unsigned();          // 
            $table->integer('team_id');          // 
            $table->string('document_name');       // 
            $table->string('document_type');                 // 
            $table->string('document_comment')->nullable();              //
            $table->string('tl_inspection_status')->nullable();          // 팀장 검사 상태            APR : 승인, REJ : 반려
            $table->string('dl_inspection_status')->nullable();          // 부장 검사 상태            APR : 승인, REJ : 반려
            $table->string('sl_inspection_status')->nullable();          // 경영팀장 검사 상태        APR : 승인, REJ : 반려
            $table->string('status')->default('REG');                    // 문서 현재 상태            REG : 등록, APR : 승인, REJ : 반려
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('expenditure_historys', function (Blueprint $table) 
        {
            $table->increments('id');                       // pk
            $table->integer('document_id')->unsigned();     // documents ID (FK)
            $table->string('item');                         // 항목
            $table->string('content');                      // 내용
            $table->string('price');                        // 금액
            $table->integer('order');                       // 순서
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
        });

        Schema::create('attachments', function (Blueprint $table) 
        {
            $table->increments('id');                               // pk
            $table->integer('document_id')->unsigned();             // documents ID (FK)
            $table->string('path');                                 // 파일 저장경로 full path
            $table->string('origin_name');                          // 원본파일이름         
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
        });
        
        // 문서 반려 코멘트 테이블
        Schema::create('comments', function(Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('document_id')->unsigned();     // documents ID (FK)
            $table->string('writer');
            $table->string('title');
            $table->string('content');
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
        // // 외래키 때문에 순서 중요함. 자식 테이블먼저 삭제.
        Schema::dropIfExists('comments');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('expenditure_historys');
        Schema::dropIfExists('documents');        
    }

}
