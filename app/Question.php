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
}
