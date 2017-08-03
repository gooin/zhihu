<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/7/15
 * Time: 14:42
 * 使用 Model中自带的方法进行CUED, 分开 Model 和 控制器
 */

namespace app\Repositories;

use App\Question;
use App\Topic;


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
    public function byIdWithTopics($id)
    {
        return Question::where('id', $id)->with('topics')->first();
    }

    public function create(array $attr)
    {
        return Question::create($attr);
    }


    public function update(array $attr)
    {
        return Question::update($attr);
    }

    public function normalizeTopic(array $topics)
    {
        // 遍历话题, 返回一个数组
        return collect($topics)->map(function ($topic) {
            // 如果话题已经存在
            if (is_numeric($topic)) {
                // 为话题的问题计数 +1
                Topic::find($topic)->increment('questions_count');
                // 返回话题id
                return (int)$topic;
            }
            // 创建新的话题, name为手动填入的name
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            // 返回新话题的id
            return $newTopic->id;
        })->toArray();
    }



    public function byId($id)
    {
        return Question::find($id);
    }
}