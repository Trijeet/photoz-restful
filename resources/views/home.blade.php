@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($albums)>0)
                        @foreach($albums as $album)
                            <div class="well">
                                <h4>{{$album->album_name}}</h4>
                            </div>
                        @endforeach
                        {{$albums->links()}}
                    @else
                        <p>No Albums Created.</p>
                    @endif
                </div>
                
            
            </div><a class="btn btn-primary" href="album/create">Create Album</a>
        </div>
    </div>
</div>
@endsection
