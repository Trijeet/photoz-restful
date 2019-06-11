@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Photo - {{$photo['photo']}}</div>
                <div class='card-body'>
                    <img src='/storage/photos/{{$photo["photo"]}}'
                        height="256" width="256"> <br><br>
                    
                    Photos Description - {{$photo['photo_description']}} <br> <br>
                    Privacy - {{['','Public','Link Accessible','Private'][$photo['privacy']]}} <br>
                    <br>
                    Created At - {{$photo['created_at']}} <br>
                    Last Modified At - {{$photo['updated_at']}} <br>
                </div>
                <br>
            </div>
            <div class='Buttons'>
            <br>
                @if(Auth::check() and $user_id === Auth::user()->id)
                    <a href="/photos/{{$photo['id']}}/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
                    <br><br>
                    {{Form::open(['action'=>['Web\PhotoController@delete',$photo['id']],
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
