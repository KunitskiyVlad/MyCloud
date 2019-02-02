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
</div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('interface.loadedFiles')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('interface.close')</button>
                        <button type="button" id="send" class="btn btn-primary">@lang('interface.send')</button>
                    </div>
                </div>
            </div>
        </div>
        </main>
        </div>
        </body>
    </html>
    <script src="{{ asset('js/UserInterface.js') }}"></script>
    <script src="{{ asset('js/DragAndDrop.js') }}"></script>
    <script src="{{asset('js/Request.js')}}"></script>
    <script src="{{ asset('js/MainPage.js')}}"></script>
@endsection
