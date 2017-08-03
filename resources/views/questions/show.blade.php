@extends('layouts.app')

@section('content')
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
                        {{--如果是问题作者查看问题, 则可以编辑问题--}}
                        {{--@if( $question->user_id == \Illuminate\Support\Facades\Auth::id())  菜鸟写法--}}
                            @if( \Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->owns($question)  )

                            <a  class="edit" href="{{$question->id}}/edit">编辑</a>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
