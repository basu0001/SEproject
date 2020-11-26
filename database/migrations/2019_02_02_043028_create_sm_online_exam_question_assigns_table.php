<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmOnlineExamQuestionAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_online_exam_question_assigns', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('online_exam_id')->nullable()->unsigned();
            $table->foreign('online_exam_id')->references('id')->on('sm_online_exams')->onDelete('cascade');

            $table->integer('question_bank_id')->nullable()->unsigned();
            $table->foreign('question_bank_id')->references('id')->on('sm_question_banks')->onDelete('cascade');

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');  
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_online_exam_question_assigns');
    }
}
