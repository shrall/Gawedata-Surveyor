@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="row justify-content-center px-2 mb-4" id="login-failed">
                        <div class="btn btn-error col-5 py-3 mx-2">
                            Email atau password tidak cocok
                        </div>
                    </div>
                @endif
                <h3 class="font-weight-bold text-center mb-5">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row mb-3 justify-content-center">
                        <div class="col-6 p-0">
                            <input id="email" type="text" class="form-control input-text" name="email" required
                                placeholder="E-Mail">
                            <span class="invalid-feedback text-end">
                                <strong>Email tidak sesuai. Contoh email : contoh@gmail.com</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6 p-0 position-relative">
                            <span
                                class="fas fa-fw fa-eye position-absolute top-50 end-0 translate-middle-y me-4 pe-4 fs-5 cursor-pointer text-gray eyeToggle" onclick="togglePassword()"></span>
                            <input id="password" type="password"
                                class="passwordInput form-control input-text @error('password') is-invalid @enderror" name="password"
                                required placeholder="Password"
                                style="padding-right:3.5rem !important;">
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
        function togglePassword() {
            if ($(".passwordInput").attr('type') == 'password') {
                $(".passwordInput").attr('type', 'text');
                $(".eyeToggle").removeClass('fa-eye');
                $(".eyeToggle").addClass('fa-eye-slash');
            } else {
                $(".passwordInput").attr('type', 'password');
                $(".eyeToggle").removeClass('fa-eye-slash');
                $(".eyeToggle").addClass('fa-eye');
            }
        }
        function validateEmail(email) {
            var regex =
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return email.match(regex)
        }

        function submitLogin() {
            if (!validateEmail($('#email').val())) {
                event.preventDefault();
                $('#email').addClass('is-invalid');
            } else if (validateEmail($('#email').val()) && $('#password').val()) {
                $('#email').removeClass('is-invalid');
                $('#login-button').html('<span class="fa fa-fw fa-spin fa-circle-notch"></span>');
            }
        }
    </script>
@endsection
