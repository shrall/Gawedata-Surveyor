@extends('layouts.app')

@section('content')
    <div class="container font-lato">
        <div class="row vh-100">
            <div class="col-3 pe-0 border-end">
                @include('user.inc.sidebar')
            </div>
            <div class="col-4">
                <div class="container ms-5">
                    <h2 class="my-5">Edit Profile</h2>
                    <div class="mb-3">
                        <input id="name" type="text" class="form-control input-login @error('name') is-invalid @enderror"
                            name="name" required placeholder="Nama">
                        @error('name')
                            <span class="invalid-feedback">
                                <strong>{{$errors->first('name') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="my-3">
                        <input id="email" type="email" class="form-control input-login @error('email') is-invalid @enderror"
                            name="email" required placeholder="E-Mail">
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row justify-content-center px-2 mt-5 mb-2">
                        <button type="submit" class="btn btn-gawedata col-12 py-2" id="login-button"
                            onclick="submitLogin();">
                            {{ __('Simpan') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(window).on('load', function() {
            $('body').addClass('overflow-hidden');
        });
    </script>
@endsection
