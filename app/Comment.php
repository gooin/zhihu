<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';

    protected $fillable = ['user_id','body','commentable_id','commentable_type'];

    // 多态关联
    public function commentable()
    {
        return $this->morphTo();
    }
}
