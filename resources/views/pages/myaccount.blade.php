@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Account</div>

                <div class="card-body">
                    <p> Username : {{Auth::user()->username}}</p>
                    <p> Name : {{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
                    <p> Email : {{Auth::user()->email}}</p>
                    <p> Gender : {{Auth::user()->gender}}</p>
                    <p> Profile Picture : </p><img src='/storage/profile_pictures/{{Auth::user()->profile_pic}}'>
                    <p> Account Created : {{Auth::user()->created_at}}</p>
                    
                </div>
            </div>
        </div>
    </div>
    
    
    
    
</div>
<a href="/user/{{Auth::user()->username}}/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
{{Form::open(['action'=>['UsersController@destroy',Auth::user()->username],
                    'method'=>'delete',
                    'class'=>'pull-right'])}}
         {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
    {{Form::close()}}
@endsection
