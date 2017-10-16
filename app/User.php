<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

//    public function follows($question)
////    {
////        // 创建用户关注的问题联系
////        return Follow::create([
////            'question_id' => $question,
////            'user_id' => $this->id
////        ]);
////    }

//  使用 toggle， 如果用户已经关注则取关，未关注则关注
    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }


    public function isFollow($question)
    {
        return !!$this->follows()->where('question_id', $question)->count();
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // 用户的答案关系, 1对多
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
