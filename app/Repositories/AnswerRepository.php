<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/10/26
 * Time: 17:15
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }
}