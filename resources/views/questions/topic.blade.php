@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      {{ $topic-id }}
                    </div>

                    <div class="panel-body">

                        @foreach($question->topics as $topic)
                            <a class="label label-info topics pull-right"
                               href="/topic/{{ $topic->id }}">{{$topic->name}}</a>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
