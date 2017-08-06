<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\StoreAnswerRequest;
use app\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    public function store(StoreAnswerRequest $request, $question)
    {
        $data = [
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body')
        ];
        $answer = Answer::create($data);
        $answer->question()->increment('answers_count');
        return back();
    }
}
