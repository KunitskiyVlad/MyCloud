@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-sm-5">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-sm-5">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-sm-5">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-sm-3 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-sm-5">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="avatar" class="col-sm-3 col-form-label text-md-right">Avatar</label>

                            <div class="col-sm-5">
                                <input id="avatar" type="file" class="form-control" name='avatar'>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="send">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</div>
<div id="crop" class="modal col-lg-10">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <H5> Выбирети миниатюру</H5>
            </div>
            <div class="modal-body">
                <div class="col-sm-4 m-1" id="originalImage"></div>
                <div class="col-sm-3 d-inline-block" id="ResizeImage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script src="{{ asset('js/UserInterface.js') }}"></script>
<script src="{{ asset('js/validation.js') }}"></script>
<script src="{{asset('js/CropAvatar.js')}}"></script>
<script src="{{asset('js/Registration.js')}}"></script>
@endsection
