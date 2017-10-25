<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

/**
 * Class FollowersController
 * @package App\Http\Controllers
 */
class FollowersController extends Controller
{


    protected $user;


    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id)
    {
        $user = $this->user->byID($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();

        if (in_array(\Auth::guard('api')->user()->id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }


    public function follow()
    {
        $userToFollow = $this->user->byID(request('user'));

        $followed = \Auth::guard('api')->user()->followThisUser($userToFollow->id);
//        return $followed;
        // 如果检测到没有关注
        if (count($followed['attached']) > 0) {
            // 字段数+1
            $userToFollow->increment('followers_count');

            // 调用notify方法
            $userToFollow->notify(new NewUserFollowNotification());
            // 返回
            return response()->json(['followed' => true]);
        }
        // 字段数-1
        $userToFollow->decrement('followers_count');
        // 返回
        return response()->json(['followed' => false]);



    }
}

