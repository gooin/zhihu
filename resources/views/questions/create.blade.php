@extends('layouts.app')

@section('content')

    @include('vendor.ueditor.assets')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发布问题</div>
                    <div class="panel-body">
                        <form action="/questions" method="post">
                        {!! csrf_field() !!}
                        <!-- 如果验证有错, class加入 has-error-->
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : ''}}">
                                <input type="text" name="title" class="form-control" placeholder="标题" id="title"
                                       value="{{old('title')}}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @else
                                    <br>
                                @endif


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
                                <button class="btn btn-info form-control" type="submit">发布问题</button>


                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


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
