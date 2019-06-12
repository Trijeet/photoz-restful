@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit User Details</div>
                @if(isset($error) and count($error)>0)
                    @foreach($error as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                @if(session('error') !== null)
                    @foreach(session('error') as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                <div class="card-body">
                {{Form::open(['action'=>['Web\UserController@edit',Auth::user()->username],
                        'method'=>'PUT',
                        'files'=>true,
                        'enctype'=> "multipart/form-data"])}}
                
                <div class='form-group'>
                    {{ Form::label('first_name', 'First Name')}}
                    {{ Form::text('first_name', isset($user)?$user->first_name:'', ['class'=>'form-control', 'placeholder'=>'Enter First Name'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('last_name', 'Last Name')}}
                    {{ Form::text('last_name', isset($user)?$user->last_name:'', ['class'=>'form-control', 'placeholder'=>'Enter Last Name'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('email', 'Email')}}
                    {{ Form::text('email', isset($user)?$user->email:'', ['class'=>'form-control', 'placeholder'=>'Enter Email'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('gender', 'Gender')}}
                    {{ Form::select('gender', ['1' => 'Male', '2'=>'Female', '3'=>'Other'],isset($user)?$user->gender:1)}}
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
