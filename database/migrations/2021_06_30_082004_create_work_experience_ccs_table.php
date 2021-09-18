<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkExperienceCcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experience_ccs', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('school_program');
            $table->string('work_name');
            $table->string('position');
            $table->longText('details');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('work_status');
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
        Schema::dropIfExists('work_experience_ccs');
    }
}
