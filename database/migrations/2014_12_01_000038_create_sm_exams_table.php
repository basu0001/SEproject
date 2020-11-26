<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_exams', function (Blueprint $table) {
            $table->increments('id'); 

            $table->float('exam_mark')->nullable(); 
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();
            

            $table->integer('exam_type_id')->nullable()->unsigned();
            $table->foreign('exam_type_id')->references('id')->on('sm_exam_types')->onDelete('cascade');

            $table->integer('class_id')->nullable()->unsigned();
            $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade');

            $table->integer('section_id')->nullable()->unsigned();
            $table->foreign('section_id')->references('id')->on('sm_sections')->onDelete('cascade');

            $table->integer('subject_id')->nullable()->unsigned();
            $table->foreign('subject_id')->references('id')->on('sm_subjects')->onDelete('cascade');

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
        Schema::dropIfExists('sm_exams');
    }
}
