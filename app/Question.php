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

    // 一对一
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  检查问题表中 is_hidden 属性,进行过滤
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }
}
