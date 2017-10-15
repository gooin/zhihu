<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable =['title', 'body', 'user_id'];

    // 指定多对多联系
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }



    //  检查问题表中 is_hidden 属性,进行过滤
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }

    // 一对一
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // 指定与回答的联系, 一对多
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'user_question')->withTimestamps();

    }
}
