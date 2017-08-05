@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        当前有 {{ $question->answers_count }} 个回答
                    </div>

                    <div class="panel-body">
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
