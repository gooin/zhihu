<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    protected $questionRepository;

    // 注入question仓库
    public function __construct(QuestionRepository $questionRepository)
    {
        // 创建,编辑问题需要登录
        $this->middleware('auth')->except(['index', 'show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 获取所有问题传入视图
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index', compact('questions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 返回视图创建问题
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
//        使用 StoreQuestionRequest请求 存储验证规则
//        /app/http/Requests/StoreQuestionRequest

//        // 数据验证规则
//        $rules = [
//            'title' => 'required|min:6|max:100',
//            'body' => 'required|min:20',
//        ];
//        $messages = [
//            'body.required' => '内容不能为空',
//            'body.min' => '内容不能少于 20 个字符'
//        ];
//        // 进行验证
//        $this->validate($request, $rules, $messages);


        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        //dd($topics);

        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];


        $question = $this->questionRepository->create($data);


        // 建立数据库的多对多联系, 填入question_topic表
        $question->topics()->attach($topics);

        // 跳转到 show
        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 从数据库按id检索问题, 同时检索话题
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);
        return view('questions.show', compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 获取问题
        $question = $this->questionRepository->byId($id);

        // 判断问题作者是否为当前用户
        if (Auth::user()->owns($question)) {
            return view('questions.edit', compact('question'));
        }
        // 不是则返回
        return back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        //
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        // 更新
        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body')
        ]);
        // 同步更新话题
        $question->topics()->sync($topics);

        // 跳转到 show
        return redirect()->route('questions.show', [$question->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question)){
            $question->delete();
            return redirect('/');
        }
        return abort(403, 'Forbidden');
    }


}
