<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/7/15
 * Time: 14:42
 */

namespace app\Repositorires;
use App\Question;


/**
 * Class QuestionRepository
 * @package app\Repositorires
 */
class QuestionRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopics($id) {
        return Question::where('id',$id)->with('topics')->first();
    }
}