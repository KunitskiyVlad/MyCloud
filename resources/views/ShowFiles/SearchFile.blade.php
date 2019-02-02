@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-10 col-md-8 file-frame offset-2">
                @foreach($files as $file)
                    <div class="col-lg-9 p-2 text-center content-file d-inline-block">

                        <div class="col-lg-12 offset-lg-2 offset-md-0 offset-sm-0 text-center align-baseline">
                            <i class="far fa-file"></i>
                            <p class="text-light">{{$file['old_name']}}</p>
                            <div class="col-4 align-baseline text-left">
                                <a class="btn btn-link show-info-button" href="#" role="button" onclick="event.preventDefault()">@lang('interface.info')</a>
                            </div>
                            <!--info-->
                            <div class="col-lg-12 text-left border-primary border info">
                                <div class="col-12  ">
                                    <div class="col-4 d-inline-block pl-0">
                                        <span class="text-light">@lang('interface.name'):</span>
                                    </div>
                                    <div class="col-5  d-inline-block">
                                        <span class="text-light">{{$file['old_name']}}</span>
                                    </div>
                                </div>

                                <div class="col-12 align-baseline">
                                    <div class="col-4 d-inline-block pl-0">
                                        <span class="text-light">@lang('interface.size'):</span>
                                    </div>
                                    <div class="col-5 d-inline-block">
                                        <span class="text-light">{{$file['size_file']}}</span>
                                    </div>
                                </div>

                                <div class="col-12 align-baseline">
                                    <div class="col-4 d-inline-block pl-0">
                                        <span class="text-light">@lang('interface.uploadedBy'):</span>
                                    </div>
                                    <div class="col-5 d-inline-block">
                                        @if(isset($UserUpload[$file['user_id']]))
                                            <span class="text-light">{{$UserUpload[$file['user_id']]['name']}}</span>
                                        @else
                                            <span class="text-light">@lang('interface.anon')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!--info-->
                        <div class="col-lg-12 offset-2 mt-2 text-center">
                            <div class="col-2 d-inline-block"> <i class="far fa-heart"></i></div>
                            <div class="col-2 d-inline-block"> <i class="far fa-comment-alt"></i></div>
                            <div class="col-2 d-inline-block" > <i class="fas fa-download" title="download {{$file['old_name']}}" data-FileName="{{$file['new_name']}}"></i></div>
                        </div>
                        <div class="col-12  offset-2">
                            <div class="col-4 align-baseline text-left text-light"> @lang('interface.downloaded') {{$file['count_download']}}</div>
                        </div>
                        <!--comments-->
                        <div class="col-lg-12 mt-2 offset-2 comment">
                            <form action="{{route('file.comment.store', $file['id'])}}" method="post" data-fileid="{{$file['id']}}">
                                {{ csrf_field() }}

                                @if(isset($comments[$file['id']]))

                                    @include('ShowFiles.SectionComment',
                                    ['comments'=>$comments[$file['id']],
                                     'author'=>$authorComment,
                                    ])
                                @endif

                                <div data-commentreply="0">

                                </div>
                                <div class="col-lg-10 col-md-12 col-sm-8 offset-2">
                                    <textarea class="form-control" rows="3" name="content"></textarea>
                                    <div class="offset-5 m-3 col-sm-10">
                                        <button type="button" class="btn btn-primary send">Отправить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--comments-->
                    </div>
                    <hr>
                @endforeach


            </div>
        </div>
    </div>
    </main>
    </div>
    </body>

    </html>
    <script src="{{ asset('js/UserInterface.js') }}"></script>
@endsection