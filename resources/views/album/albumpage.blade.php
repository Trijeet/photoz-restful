@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Album - {{$album['album_name']}}</div>
                <div class='card-body'>
                    <img src='/storage/cover_pictures/{{$album["cover_picture"]}}'
                        height="256" width="256"> <br><br>
                    
                    Album Description - {{$album['album_description']}} <br> <br>
                    Privacy - {{['','Public','Link Accessible','Private'][$album['privacy']]}} <br>
                    <br>
                    Created At - {{$album['created_at']}} <br>
                    Last Modified At - {{$album['updated_at']}} <br>
                </div>
                <br>
                <div class="card-header">Photos</div>
                <div class='card-body'>
                    @if(isset($photos) and count($photos)>0)
                        @foreach($photos as $photo)
                            <div>
                                <h6>{{$loop->iteration}}.  
                                    <a href="/photos/{{$photo['id']}}">{{$photo['photo']}} {{$photo['id']}}<a>
                                </h6>
                            </div>
                        @endforeach
                    @else
                        No photos to show.
                    @endif
                    <br>
                    @if(Auth::check() and $album['user_id'] === Auth::user()->id)
                        <a href='/photos/upload/{{$album["id"]}}' class="btn btn-primary" class="row justify-content-right">Add Photo<a>
                    @endif
                </div>
            </div>
            <div class='Buttons'>
            <br>
                @if(Auth::check() and $album['user_id'] === Auth::user()->id)
                    <a href="/albums/{{$album['id']}}/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
                    <br><br>
                    {{Form::open(['action'=>['Web\AlbumController@delete',$album['id']],
                                'method'=>'delete',
                                'class'=>'pull-right',
                                'onsubmit' => 'return ConfirmDelete()'])}}
                        {{Form::submit('Delete',['class'=>'btn btn-danger pull-right'])}}
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
                @endif
            </div>
        </div> 
    </div>
</div>
@endsection
