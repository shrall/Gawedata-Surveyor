@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="font-weight-bold text-center mb-5">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row mb-3 justify-content-center">
                        <div class="col-6">
                            <input id="email" type="email"
                                class="form-control input-login @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autofocus placeholder="E-Mail">
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <input id="password" type="password"
                                class="form-control input-login @error('password') is-invalid @enderror" name="password"
                                value="{{ old('password') }}" required autocomplete="password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-center py-2">
                        <a class="col-6 text-gawedata text-end text-decoration-none font-weight-regular"
                            href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    </div>
                    <div class="row justify-content-center px-2 mt-5 mb-2">
                        <button type="submit" class="btn btn-gawedata col-6 py-2" id="login-button"
                            onclick="submitLogin();">
                            {{ __('Masuk') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function submitLogin() {
            if ($('#email').val() && $('#password').val()) {
                $('#login-button').html('<span class="fa fa-fw fa-spin fa-circle-notch"></span>');
            }
        }
    </script>
@endsection
