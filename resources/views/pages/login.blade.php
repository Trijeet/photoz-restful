@extends('layouts.app')

@section('content')

    <div class="container">
    <h1>Register New User</h1>

    {{Form::open(['action'=>'Api\PassportController@login',
                'method'=>'POST'])}}
        <div class='.form-group'>
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
@endsection
