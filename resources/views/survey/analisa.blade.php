@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end">
                @include('survey.inc.sidebar')
            </div>
            <div class="col-7 text-center my-4 d-none">
            </div>
        </div>
    </div>
@endsection
