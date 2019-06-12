@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List of Users</div>
                @if(session('error') !== null)
                    <div class='alert alert-danger'>
                        {{session('error')}}
                    </div>
                @endif
                <div class='card-body'>                    
                    @if(isset($users) and count($users)>0)
                        @foreach($users as $user)                            
                            <div>
                                <h6>{{$loop->iteration}}.  
                                    <a href="/users/{{$user['username']}}">{{$user['username']}}<a>
                                </h6>
                            </div>
                        @endforeach
                    @else
                        No Users to show.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
