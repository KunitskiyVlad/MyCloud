@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="file-frame col-lg-7 offset-2">
                <div class="col-sm-6 col-md-8 col-lg-9 info-user offset-1 ">
                    <div class="col-sm-10">
                        <label class="col-sm-4">@lang('interface.name')</label>
                        <span class="col-sm-4">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="col-sm-10">
                        <label class="col-sm-4">Email</label>
                        <span class="col-sm-4">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="col-sm-10">
                        <label class="col-sm-4">@lang('interface.uploadFiles')</label>
                        <span class="col-sm-4">{{$count}} ({{$SizeUpload}})</span>
                    </div>

                </div>
            <hr>
                <div class="col-sm-8 col-md-10 col-lg-12 offset-1 form-horizontal mb-5">
                    <H2>Настройки</H2>
                    <form class="form-horizontal" action="{{route('profile.update', Auth::user())}}" method="post">
                        <input type="hidden" name="_method" value="put">
                        {{ csrf_field() }} {{-- Form include --}}


                        <div class="col-md-9">
                            <label class="col-sm-2"  >@lang('interface.name')</label>
                            <input class="col-md-9" name="name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-9">
                            <label class="col-sm-2" >Email</label>
                            <input class="col-md-9" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="offset-6 p-2">
                            <button type="submit" class="btn btn-primary of">@lang('interface.save')</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
@endsection