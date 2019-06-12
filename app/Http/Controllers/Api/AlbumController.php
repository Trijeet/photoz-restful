<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Route;

use App\Album;
use App\Photo;
use Auth;

class AlbumController extends Controller
{
    
    //Create a new Album for authenticated user
    //Returns 201 and album id on success
    public function store(Request $request) //POST
    {
        try
        {
            //Validate the data
            try
            {
                $this->validate($request, [
                    'album_name' => ['required', 'string'],
                    'album_description' => ['nullable','string'],
                    'privacy' => ['required','integer','between:1,3'],
                    'cover_picture' => ['nullable','image','max:1999'],
                ]);
            }
            catch (\Illuminate\Validation\ValidationException $e ) {
                return response()->json($e->errors(),400);
            }
            $file_to_store = 'noimage.jpg'; //default image
                
            if($request->cover_picture !== null)
            {
                $filename = $request->file('cover_picture')->getClientOriginalName();
                $file_first = pathinfo($filename,PATHINFO_FILENAME);
                $extension = $request->file('cover_picture')->getClientOriginalExtension();

                $file_to_store = $file_first.'_'.time().'.'.$extension;
                $path=$request->file('cover_picture')->storeAs('public/cover_pictures',$file_to_store);
            }

            $user_id = auth()->user()->id;
            $album = Album::create([
                'user_id' => $user_id,
                'album_name' => $request->album_name,
                'album_description' => $request->album_description,
                'privacy' => $request->privacy,
                'cover_picture' => $file_to_store,
            ]);

            return response()->json([
                    'success' => true,
                    'album' => $album->id],201);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()], 500);
        }
    }

    //Updates the album = $id, authenticated
    //Returns status 200 for success
    public function update(Request $request, $id) //PUT
    {
        try{           

            $album =Album::where('id',$id)
                        ->where('user_id',auth()->user()->id);
            if(count($album->get())===0)
                return response()->json([
                    'success' => false,
                    'message' => 'Album not found or Unauthorized'], 400);
            
            $old_photo = Album::where('id',$id)->pluck('cover_picture')->first();

            //Validate the data
            try
            {
                $this->validate($request, [
                    'album_name' => ['required', 'string'],
                    'album_description' => ['nullable','string'],
                    'privacy' => ['required','integer','between:1,3'],
                    'cover_picture' => ['nullable','image','max:1999'],
                ]);
            }
            catch (\Illuminate\Validation\ValidationException $e ) {
                return response($e->errors(),400);
            }

            $file_to_store = $old_photo;
                
            if($request->cover_picture != null)
            {
                //Delete Old Image
                Storage::delete('public/cover_pictures/'.$old_photo);
                //Save the new image
                $filename = $request->file('cover_picture')->getClientOriginalName();
                $file_first = pathinfo($filename,PATHINFO_FILENAME);
                $extension = $request->file('cover_picture')->getClientOriginalExtension();
                $file_to_store = $file_first.'_'.time().'.'.$extension;
                $path=$request->file('cover_picture')->storeAs('public/cover_pictures',$file_to_store);
            }
            $album= Album::where('id',$id)->update([
                'album_name' => $request->album_name,
                'album_description' => $request->album_description,
                'privacy' => $request->privacy,
                'cover_picture' => $file_to_store,
            ]);

            return response()->json([], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()], 500);
        }
    }

    //Return album data, if album - public,link_accessible or user owns album
    //Also returns public photos belonging to that album
    //If user owns the album, returns all photos
    public function show($id)
    {
        
        try{
            //Get the album
            $album = Album::where('id',$id);        
            
            if(count($album->get()) === 0) //No album present
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Album not found'
                ],404);
            }
            //Get user
            $user = $album->pluck('user_id')->first();
            //Get privacy
            $privacy = $album->pluck('privacy')->first();

            if(auth()->check() and auth()->user()->id === $user)
            {   
                //return album data + all photos
                $photos = Photo::where('album_id',$id);
                
                return response()->json([
                    'success' => true,
                    'data' => $album->get(),
                    'photos' => $photos->get()
                ],200);
            }
            else if($privacy === 1 or $privacy === 2) //album is public or link
            {
                //return album data + only public photos
                $photos = Photo::where('album_id',$id)
                                ->where('privacy','=','1');
                return response()->json([
                    'success' => true,
                    'data' => $album->get(),
                    'photos' => $photos->get()
                ],200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'],401);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()], 500);
        }
    }

    

    //Delete Album with id=$id if authenticated user owns it
    //Returns 200 for success
    public function destroy($id)    //DELETE
    {
        try
        {
            //Get exact album to be deleted
            $album =Album::where('id',$id);
            
            if(count($album->get())===0)
                return response()->json([
                    'success' => false,
                    'message' => 'Album not found'], 404);

            //Get associated user
            $user = $album->pluck('user_id')->first();
            //Get cover photo
            $cover = $album->pluck('cover_picture')->first();

            //Verify user
            if(auth()->user()->id === $user)
            {
                //Delete photos associated with album
                $photos = Photo::where('album_id',$id);
                foreach($photos->get() as $photo)
                {
                    $request = Request::create('/api/photos/'.$photo['id'],'DELETE');
                    $response = app()->handle($request);//Route::dispatch($request);
                }
                //Delete from Storage
                if($cover !== 'noimage.jpg')
                {
                    Storage::delete('/public/cover_pictures/'.$cover);
                }
                $album = $album->delete();  
                return response()->json([], 200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized'
                ],401);
            }

        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()], 500);
        }
    }
}
