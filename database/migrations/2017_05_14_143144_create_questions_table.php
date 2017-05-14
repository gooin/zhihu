<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); // 问题名字
            $table->text('body');   // 问题内容
            $table->integer('user_id')->unsigned(); // 提问者 id
            $table->integer('comments_count')->default(0); // 评论数
            $table->integer('followers_count')->default(0); // 关注数
            $table->integer('answers_count')->default(0); // 关注数
            $table->string('close_comment',8)->default('F'); // 关闭评论
            $table->string('is_hidden',8)->default('F'); // 隐藏
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
        Schema::dropIfExists('questions');
    }
}
