@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Photo</div>
                @if(isset($error) and count($error)>0)
                    @foreach($error as $k =>$v)
                        <div class='alert alert-danger'>
                            {{$v[0]}}
                        </div>
                    @endforeach                    
                @endif
                <div class="card-body">
                    {{Form::open(['action'=>['Web\PhotoController@edit',$photo_id],
                            'method'=>'PUT',
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
                        {{Form::hidden('album_id',$album_id)}}
                        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                        {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
