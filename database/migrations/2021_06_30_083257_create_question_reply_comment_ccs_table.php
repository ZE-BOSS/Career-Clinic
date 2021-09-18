<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionReplyCommentCcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_reply_comment_ccs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_category');
            $table->integer('reply_id');
            $table->string('reply');
            $table->longText('link');
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
        Schema::dropIfExists('question_reply_comment_ccs');
    }
}
