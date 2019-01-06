@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="d-inline-block col-lg-4 col-sm-5 pr-0 col-4">

                <div class="col-lg-12  custom-select-lg selected" >Загрузка файлов</div>
                <div class="col-lg-12  custom-select-lg field-select" >Загрузка по ссылке</div>

            </div>
            <div class="col-lg-6 upload-field text-center col-sm-7 col-5">
                <div class="col-lg-12 p-3">
                <h5 class="text-light">Перетащите на страницу для загрузки</h5>
                </div>
                <form action="{{route('file.store')}}" method="post" id="formFile" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="post">
                    {{ csrf_field() }}
                        <input type="file" multiple name="files">
                    <button class="btn btn-primary" type="submit">Отправить</button>
                    </form>
            </div>

        </div>
    </div>
    @endsection