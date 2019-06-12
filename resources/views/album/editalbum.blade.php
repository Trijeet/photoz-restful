@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Album : {{session('album_name')}}</div>
                @if(session('error') !== null)
                    @foreach(session('error') as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                <div class="card-body">
                {{Form::open(['action'=>['Web\AlbumController@edit',session('album_id')],
                        'method'=>'PUT',
                        'files'=>true,
                        'enctype'=> "multipart/form-data"])}}
                
                <div class='form-group'>
                    {{ Form::label('album_name', 'Album Name')}}
                    {{ Form::text('album_name', isset($album)?$album->album_name:'', ['class'=>'form-control', 'placeholder'=>'Enter Album Name'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('album_description', 'Album Description')}}
                    {{ Form::textarea('album_description', isset($album)?$album->album_description:'', ['class'=>'form-control', 'placeholder'=>'Enter Album Description'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('privacy', 'Privacy')}}
                    {{ Form::select('privacy', ['1' => 'Public', '2'=>'Link Accessible', '3'=>'Private'],isset($album)?$album->privacy:1)}}
                </div>
                <div class='form-group'>
                    {{ Form::label('cover_picture', 'Cover Picture')}}
                    {{ Form::file('cover_picture')}}
                </div>
                    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
