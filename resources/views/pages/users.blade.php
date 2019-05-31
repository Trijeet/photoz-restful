@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List of Users - </div>

                <div class="card-body">
                @if(count($users)>0)
                        @foreach($users as $user)
                            <div class="well">
                                <h6>{{$loop->iteration}}.  
                                    <a href="/user/{{$user->username}}"> {{$user->username}}
                                <a></h6>
                            </div>
                        @endforeach
                        {{$users->links()}}
                    @else
                        <p>No User found.</p>
                    @endif
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
