@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if(isset($message))
                    <div class='alert alert-danger'>
                        {{$message}}
                    </div>                
                @endif
            <div class="card">
                <div class="card-header">Dashboard</div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(session('error') !== null)                        
                        <div class='alert alert-danger'>
                            {{session('error')}}
                        </div>
                    @endif
                    @if(session('success') !== null)                        
                        <div class='alert alert-success'>
                            {{session('success')}}
                        </div>
                    @endif

                    @if(isset($albums) and count($albums)>0)
                        @foreach($albums as $album)
                            <div>
                                <h6>{{$loop->iteration}}.  
                                <a href="/albums/{{$album['id']}}">{{$album['album_name']}}<a>
                                </h6>
                            </div>
                        @endforeach
                    @else
                        No Albums to Show
                    @endif
                    
                </div>
            
            </div><a class="btn btn-primary" href="/albums/create">Create Album</a>
        </div>
    </div>
</div>
@endsection
