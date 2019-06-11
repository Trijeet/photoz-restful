@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                    @if(isset($error) and count($error)>0)
                        @foreach($error as $k =>$v)
                            <div class='alert alert-danger'>
                                {{$v[0]}}
                            </div>
                        @endforeach                    
                    @endif
                    <div class="card-body">
                        {{Form::open(['action'=>'Web\UserController@login',
                                'method'=>'POST'])}}
                        <div class='form-group'>
                            {{ Form::label('username', 'Username', ['class'=>'control-label'])}}
                            {{ Form::text('username', '', ['class'=>'form-control', 'placeholder'=>'Enter Username'])}}
                        </div>
                        <div class='form-group'>
                            {{ Form::label('password', 'Password')}}
                            {{ Form::password('password',['class'=>'form-control']) }}
                        </div>
                            {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                            {{Form::close()}}
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
