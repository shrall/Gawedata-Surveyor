@extends('layouts.app')

@php
$user = Http::withHeaders([
    'Authorization' => 'Bearer ' . session('token'),
])
    ->get(config('services.api.url') . '/details')
    ->json()['data'];
@endphp

@section('content')
    <div class="container font-lato">
        <div class="row vh-100">
            <div class="col-3 pe-0 border-end">
                @include('user.inc.sidebar')
            </div>
            <div class="col-4">
                <div class="container ms-5">
                    <form action="{{ route('user.updateprofile') }}" method="post">
                        @csrf
                        <h2 class="my-5">Edit Profile</h2>
                        <div class="mb-3">
                            <input id="name" type="text" class="form-control input-text" name="name" required
                                placeholder="Nama" value="{{ $user['name'] }}">
                        </div>
                        <div class="my-3">
                            <input id="email" type="email" class="form-control input-text" name="email" required
                                placeholder="E-Mail" value="{{ $user['email'] }}">
                        </div>
                        <div class="row justify-content-center px-2 mt-5 mb-2">
                            <button type="submit" class="btn btn-gawedata col-12 py-2">
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
@endsection
