@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register New User</div>
                @if(session('error') !== null)
                    @foreach(session('error') as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                <div class="card-body">
                {{Form::open(['action'=>'Web\UserController@register',
                        'method'=>'POST',
                        'files'=>true,
                        'enctype'=> "multipart/form-data"])}}
                <div class='form-group'>
                    {{ Form::label('username', 'Username', ['class'=>'control-label'])}}
                    {{ Form::text('username', '', ['class'=>'form-control', 'placeholder'=>'Enter Username'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('first_name', 'First Name')}}
                    {{ Form::text('first_name', '', ['class'=>'form-control', 'placeholder'=>'Enter First Name'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('last_name', 'Last Name')}}
                    {{ Form::text('last_name', '', ['class'=>'form-control', 'placeholder'=>'Enter Last Name'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('email', 'Email')}}
                    {{ Form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Enter Email'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('gender', 'Gender')}}
                    {{ Form::select('gender', ['1' => 'Male', '2'=>'Female', '3'=>'Other'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('profile_picture', 'Profile Picture')}}
                    {{ Form::file('profile_picture')}}
                </div>
                <div class='form-group'>
                    {{ Form::label('password', 'Password')}}
                    {{ Form::password('password',['class'=>'form-control']) }}
                </div>
                <div class='form-group'>
                    {{ Form::label('password_confirmation', 'Confirm Password')}}
                    {{ Form::password('password_confirmation',['class'=>'form-control']) }}
                </div>


                    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
