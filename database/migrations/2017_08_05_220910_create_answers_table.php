<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned(); // 关联回答的用户id
            $table->integer('question_id')->index()->unsigned(); // 关联回答的问题id
            $table->text('body'); // 问题内容
            $table->integer('votes_count')->default(0); // 点赞总数, 默认为0
            $table->integer('comments_count')->default(0); // 评论总数, 默认为0
            $table->string('is_hidden',8)->default('F'); // 是否隐藏(可能违规);
            $table->string('close_comment',8)->default('F'); // 是否关闭评论 ;
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
        Schema::dropIfExists('answers');
    }
}
