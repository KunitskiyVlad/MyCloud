@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row">
    <div class="col-lg-7 loader align-middle mx-auto">
        <div class="col-lg-12 mt-2 text-center">
        <button class="btn btn-primary align-middle" id="load" type="submit">@lang('interface.loadButton')</button>
            <p class="text-light">@lang('interface.DownloadDescription')</p>
        </div>
        <div class="col-lg-12 mt-2" >
        <div class="col-lg-12  text-center" >
            <span class="symbol-dragAndDrop align-middle"></span>
            <span class="text-light align-middle">@lang('interface.DragAndDropHelp')</span>
        </div>
    </div>
        <form action="{{route('file.store')}}" method="post" id="formFile" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="post">
        {{ csrf_field() }}
        <input type="file" multiple name="files" id="inputFile" class="file-input">
        </form>

    <!--<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>-->
</div>

            <!--<div class="success-window">
                <div class="check"></div>
                <span>Файл успешно загружен</span>
            </div>-->
            </main>
        </div>
        </body>

        </html>
    <script src="{{ asset('js/UserInterface.js') }}"></script>
    <script src="{{ asset('js/DragAndDrop.js') }}"></script>
    <script>new DragAndDropFiles(document.body)

    </script>
@endsection
