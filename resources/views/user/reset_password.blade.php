@extends('layouts.app')

@section('content')
    <div class="container font-lato">
        <div class="row vh-100">
            <div class="col-3 pe-0 border-end">
                @include('user.inc.sidebar')
            </div>
            <div class="col-4">
                <div class="container ms-5">
                    <form action="{{ route('user.updatepassword') }}" method="post">
                        @csrf
                        <h2 class="my-5">Reset Password</h2>
                        <div class="mb-3 position-relative">
                            <input id="current_password" type="password" class="form-control input-text"
                                name="current_password" required placeholder="Password Lama">
                            <span id="eye-current-password"
                                class="fa fa-fw fa-eye cursor-pointer position-absolute top-50 end-0 translate-middle-y pe-4 me-3 fs-6 text-gray"
                                onclick="togglecurrentPassword()"></span>
                            @error('current_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="my-3 position-relative">
                            <input id="new_password" type="password" class="form-control input-text" name="new_password"
                                required placeholder="Password Baru">
                            <span id="eye-new-password"
                                class="fa fa-fw fa-eye cursor-pointer position-absolute top-50 end-0 translate-middle-y pe-4 me-3 fs-6 text-gray"
                                onclick="toggleNewPassword()"></span>
                            @error('new_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="my-3 position-relative">
                            <input id="new_password_confirmation" type="password" class="form-control input-text"
                                name="new_password_confirmation" required placeholder="Konfirmasi Password Baru">
                            <span id="eye-new-password-confirmation"
                                class="fa fa-fw fa-eye cursor-pointer position-absolute top-50 end-0 translate-middle-y pe-4 me-3 fs-6 text-gray"
                                onclick="toggleNewPasswordConfirmation()"></span>
                            @error('new_password_confirmation')
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row justify-content-center px-2 mt-5 mb-2">
                            <button type="submit" class="btn btn-gawedata col-12 py-2" id="login-button"
                                onclick="submitLogin();">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </form>
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
    <script>
        function togglecurrentPassword() {
            if ($("#current_password").attr('type') == 'password') {
                $("#current_password").attr('type', 'text');
                $("#eye-current-password").removeClass('fa-eye');
                $("#eye-current-password").addClass('fa-eye-slash');
            } else {
                $("#current_password").attr('type', 'password');
                $("#eye-current-password").removeClass('fa-eye-slash');
                $("#eye-current-password").addClass('fa-eye');
            }
        }

        function toggleNewPassword() {
            if ($("#new_password").attr('type') == 'password') {
                $("#new_password").attr('type', 'text');
                $("#eye-new-password").removeClass('fa-eye');
                $("#eye-new-password").addClass('fa-eye-slash');
            } else {
                $("#new_password").attr('type', 'password');
                $("#eye-new-password").removeClass('fa-eye-slash');
                $("#eye-new-password").addClass('fa-eye');
            }
        }

        function toggleNewPasswordConfirmation() {
            if ($("#new_password_confirmation").attr('type') == 'password') {
                $("#new_password_confirmation").attr('type', 'text');
                $("#eye-new-password-confirmation").removeClass('fa-eye');
                $("#eye-new-password-confirmation").addClass('fa-eye-slash');
            } else {
                $("#new_password_confirmation").attr('type', 'password');
                $("#eye-new-password-confirmation").removeClass('fa-eye-slash');
                $("#eye-new-password-confirmation").addClass('fa-eye');
            }
        }
    </script>
@endsection
