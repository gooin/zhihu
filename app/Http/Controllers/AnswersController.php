<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswersController extends Controller
{
    //

    public function store(Request $request, $question)
    {
        dd($request->all());
    }
}
