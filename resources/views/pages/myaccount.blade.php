@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Account</div>
                <div class='card-body'>
                    <img src='/storage/profile_pictures/{{$data["profile_picture"]}}'
                        height="256" width="256"> <br><br>
                    
                    Username - {{$data['username']}} <br>
                    Name - {{$data['first_name']}} {{$data['last_name']}}<br>
                    Email - {{$data['email']}} <br>
                    Gender - {{['','Male','Female','Other'][$data['gender']]}} <br>
                    <br>
                    Created At - {{$data['created_at']}} <br>
                    Last Modified At - {{$data['updated_at']}} <br>
                </div>
            </div>
            <a href="/users/{{Auth::user()->username}}/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
            <br>
            {{Form::open(['action'=>['Web\UserController@delete',Auth::user()->username],
                        'method'=>'delete',
                        'class'=>'pull-right',
                        'onsubmit' => 'return ConfirmDelete()'])}}
                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
            {{Form::close()}}
            <script>
                function ConfirmDelete()
                {
                var x = confirm("Are you sure you want to delete your account?");
                if (x)
                    return true;
                else
                    return false;
                }
            </script>
        </div> 
    </div>
</div>
@endsection
