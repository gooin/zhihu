@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($questions as $question)
                    <div class="media">
                        <div class="media-left">
                            {{--<button class="btn btn-info">此处有个头像可以点击</button>--}}
                            {{--数据库user表里头像路径不对--}}

                            <a href="#">
                                <img src="http://temp.im/78x78/fff/787878" alt="">
                                {{--<img src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">--}}
                                {{--{{ $question->user->name }}--}}
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="media-heading">
                                <a href="/questions/{{$question->id}}">
                                    {{ $question->title }}
                                </a>
                            </div>
                        </div>

                    </div>

                @endforeach

            </div>
        </div>
    </div>

@endsection
