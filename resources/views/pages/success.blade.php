@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Success!</div>
                <div class='card-body'>
                    @if(isset($message))
                        {{$message}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
