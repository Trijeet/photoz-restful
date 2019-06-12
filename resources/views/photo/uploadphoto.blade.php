@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Photo</div>
                @if(session('error') !== null)
                    @foreach(session('error') as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                <div class="card-body">
                    {{Form::open(['action'=>'Web\PhotoController@create',
                            'method'=>'POST',
                            'files'=>true,
                            'enctype'=> "multipart/form-data"])}}

                    <div class='form-group'>
                        {{ Form::label('photo_description', 'Description')}}
                        {{ Form::textarea('photo_description', '', ['class'=>'form-control', 'placeholder'=>'Enter a description for the photo'])}}
                    </div>
                    <div class='form-group'>
                        {{ Form::label('privacy', 'Privacy')}}
                        {{ Form::select('privacy', ['1' => 'Public', '2'=>'Link Accessible', '3'=>'Private'])}}
                    </div>
                    <div class='form-group'>
                        {{ Form::label('photo', 'Upload Photo')}}
                        {{ Form::file('photo')}}
                    </div>
                        {{Form::hidden('album_id',session('id'))}}
                        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                        {{Form::close()}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
