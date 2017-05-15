<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $fillable = ['name', 'questions_count'];

    // 指定多对多联系
    public function questions()
    {
        return $this->belongsToMany(Questions::class)->withTimestamps();
    }
}
