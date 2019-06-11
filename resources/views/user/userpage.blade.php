@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User - {{$user['username']}}</div>
                <div class='card-body'>
                    <img src='/storage/profile_pictures/{{$user["profile_picture"]}}'
                        height="256" width="256"> <br><br>
                    
                    Name - {{$user['first_name']}} {{$user['last_name']}}<br>
                    Email - {{$user['email']}} <br>
                    Gender - {{['','Male','Female','Other'][$user['gender']]}} <br>
                    <br>
                    Created At - {{$user['created_at']}} <br>
                    Last Modified At - {{$user['updated_at']}} <br>
                </div>
                <br>
                <div class="card-header">Albums</div>
                <div class='card-body'>
                    @if(isset($albums) and count($albums)>0)
                        @foreach($albums as $album)
                            <div>
                                <h6>{{$loop->iteration}}.  
                                    <a href="/albums/{{$album['id']}}">{{$album['album_name']}}<a>
                                </h6>
                            </div>
                        @endforeach
                    @else
                        No albums to show.
                    @endif
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection
