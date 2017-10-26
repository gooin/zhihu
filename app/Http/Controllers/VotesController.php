<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class VotesController extends Controller
{

    protected $answer;

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    //
    public function users($id)
    {
        $user = Auth::guard('api')->user();

        if ($user->hasVotedFor($id)) {
            return response()->json(['voted' => 'true']);
        }
        return response()->json(['voted' => 'false']);

    }

    public function vote()
    {
        $answer = $this->answer->byId(request('answer'));

        $voted = Auth::guard('api')->user()->VoteFor(request('answer'));
//        return $voted;
        // 如果检测到没有关注
        if (count($voted['attached']) > 0) {
            // 字段数+1
            $answer->increment('votes_count');

            // 调用notify方法进行通知
//            $userToFollow->notify(new NewUserFollowNotification());
            // 返回

            return response()->json(['voted' => true]);
        }
        // 字段数-1
        $answer->decrement('votes_count');
        // 返回
        return response()->json(['voted' => false]);
    }
}
