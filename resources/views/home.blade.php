@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <form method="post" action="{{route('fileUpload')}}" enctype="multipart/form-data" >
        @csrf
        <input
            type="file"
            name="uploaded_file"
            accept="image/*"
        >
        <button type="submit">Upload</button>
    </form>
    @if($error)
        {{$error}}
    @endif
</div>
@endsection
