@extends('layouts.app')

@section('content')
    {{--引用 UE 编辑器--}}
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
                            </div>
                            <!-- 选择话题-->
                            <div class="form-group">
                                <label for="topic">话题</label>
                                <select class="js-example-placeholder-multiple form-control" name="topics[]" multiple="multiple" >
                                </select>
                            </div>

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
                                <button class="btn btn-info form-control" type="submit">发布问题</button>
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
        <!-- select 2 -->
        $(document).ready(function () {
            function formatTopic (topic) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel"   +
                    "</div></div></div>";
            }

            function formatTopicSelection (topic) {
                return topic.name || topic.text;
            }

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 2,
                ajax: {
                    url: '/api/topics',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatTopic,
                templateSelection: formatTopicSelection,
                escapeMarkup: function (markup) { return markup; }
            });
        });

    </script>
@endsection






