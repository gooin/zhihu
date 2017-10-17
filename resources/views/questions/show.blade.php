@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic pull-right"
                               href="/topic/{{ $topic->id }}">{{$topic->name}}</a>
                        @endforeach
                    </div>

                    <div class="panel-body">
                        {!! $question->body !!}
                    </div>

                    <div class="actions">
                        {{--如果是问题作者查看问题, 则可以编辑问题--}}
                        {{--@if( $question->user_id == \Illuminate\Support\Facades\Auth::id())  菜鸟写法--}}
                        @if( \Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->owns($question)  )
                            <a class="edit" href="{{$question->id}}/edit">编辑</a>
                            <form action="/questions/{{$question->id}}" method="post" class="delete-form">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif

                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body question-follow">
                        {{--<a href="/question/{{$question->id}}/follow"--}}
                        {{--class="btn {{Auth::user()->isFollow($question->id) ? 'btn-success' : 'btn-default' }}">--}}
                        {{--{{Auth::user()->isFollow($question->id) ? '已关注' : '关注问题' }}--}}
                        {{--</a>--}}
                        <question-follow-button question="{{$question->id}}"></question-follow-button>
                        <a href="#container" class="btn btn-primary">撰写回答</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->answers_count }} 个答案
                    </div>

                    <div class="panel-body">

                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="/user/{{$answer->user->name}}">
                                        <img src="{{ $answer->user->avatar }}" width="50px"
                                             alt="{{ $answer->user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/user/{{$answer->user->name}}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h4>
                                    {!!  $answer->body !!}
                                </div>
                            </div>
                        @endforeach

                        @if( \Illuminate\Support\Facades\Auth::check())
                            <form action="/questions/{{$question->id}}/answer" method="post">
                            {!! csrf_field() !!}
                            <!-- 如果验证有错, class加入 has-error-->
                                <div class="form-group {{$errors->has('body') ? ' has-error' : ''}}">
                                    <!-- 编辑器容器 -->
                                    <script id="container" name="body" type="text/plain">
                                        {!! old('body') !!}
                                    </script>

                                    @if ($errors->has('body'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                    @else
                                        <br>
                                    @endif
                                    <button class="btn btn-info form-control" type="submit">提交答案</button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <a href="{{ url('login') }}" class="">登录</a>后提交答案
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>关于作者</span>
                    </div>

                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img width="60" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="media-heading">
                                    <a href="">
                                        <h4>{{$question->user->name}}</h4>
                                    </a>
                                </div>
                                此处用户介绍{{$question->user->email}}
                            </div>
                            <hr>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{$question->user->answers_count}}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{$question->user->questions_count}}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{$question->user->followers_count}}</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                            <a href="#container" class="btn btn-primary">发送私信</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            // 设置高度
            initialFrameHeight: 200,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });
    </script>
@endsection
