<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionShareCcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_share_ccs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_category');
            $table->integer('question_id');
            $table->string('platform');
            $table->string('shared_to');
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
        Schema::dropIfExists('question_share_ccs');
    }
}
