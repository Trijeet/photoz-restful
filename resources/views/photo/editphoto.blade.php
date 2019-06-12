@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Photo</div>
                @if(session('error') !== null)
                    @foreach(session('error') as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                
                <div class="card-body">
                {{Form::open(['action'=>['Web\PhotoController@edit',session('photo_id')],
                        'method'=>'PUT'])}}
                
                <div class='form-group'>
                    {{ Form::label('photo_description', 'Photo Description')}}
                    {{ Form::textarea('photo_description', isset($photo)?$photo->photo_description:'', ['class'=>'form-control', 'placeholder'=>'Enter Photo Description'])}}
                </div>
                <div class='form-group'>
                    {{ Form::label('privacy', 'Privacy')}}
                    {{ Form::select('privacy', ['1' => 'Public', '2'=>'Link Accessible', '3'=>'Private'],isset($photo)?$photo->privacy:1)}}
                </div>
                    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
