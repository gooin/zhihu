<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = ['user_id', 'question_id', 'body'];


    // 指定答案与用户的联系 1对1 联系
    public function user()
    {
        return $this->belongsTo(User::class);
     }
    // 指定答案与问题的联系 1对1 联系
    public function question()
    {
        return $this->belongsTo(Question::class);
     }
}
