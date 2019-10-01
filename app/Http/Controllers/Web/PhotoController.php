<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;

use App\Album;
use App\Photo;
use App\Likes_Photo;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }
    public function upload($id)
    {
        $album=Album::find($id);
        if($album == null or Auth::guest() or Auth::user()->id !== $album->user_id)
            return redirect('/home')->with('error','Unauthorized');
        else
            return view('photo.uploadphoto')->with(session(['id'=>$id]));
    }

    public function create(Request $request)
    {
        $req = new Client;
        try
        {
            $response = $req->request('POST',url('/').'/api/photos',[
                    'headers' => [
                        'Authorization' => 'Bearer '.Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ],
                    'multipart' => [
                        [
                            'name' => 'privacy',
                            'contents' => $request->privacy
                        ],
                        [
                            'name' => 'photo',
                            'contents' => ($request->file('photo') === null)?'':fopen($request->file('photo'), 'r'),
                            'filename' => ($request->file('photo') === null)?'':$request->file('photo')->getClientOriginalName()
                        ],
                        [
                            'name' => 'album_id',
                            'contents' => $request->album_id
                        ],
                        [
                            'name' => 'photo_description',
                            'contents' => $request->photo_description
                        ]
                    ]
            ]);
        }        
        catch(BadResponseException $ex)
        {
            $data = json_decode($ex->getResponse()->getBody()->getContents(), true);
            $errors = [];
            foreach($data as $k=>$v)
                $errors[$k]=$v;
            //dd($ex->getResponse());
            return redirect('/photos/upload/'.$request->album_id)->with('error',$errors)->with('id',$request->album_id);
        }
        if($response->getStatusCode() == 201)
        {   
            $photo_id = json_decode($response->getBody(),true)['photo'];
            return redirect('/photos/'.$photo_id)->with('success','Photo Uploaded Successfully!');
        }
        else
        {   
            return 'Internal Server Error!<br>Check api/photos/create<br>';
        }  
    }

    public function editphoto($id)
    {
        $photo = Photo::find($id);
        if($photo === null)
            return redirect('/home')->with('error','No Such Photo');
        $album = Album::find($photo->album_id);
        if($album == null or Auth::guest() or Auth::user()->id!==$album->user_id)
            return redirect('/home')->with('error','Unauthorized Access');
        else
            return view('photo.editphoto')->with(session(['photo_id'=>$id]))
                ->with('photo',$photo);            
    }

    public function edit(Request $request, $id)
    {
        $req = new Client;            
        try
        {
            $response = $req->request('POST',url('/').'/api/photos/'.$id,[
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ],
                    'multipart' => [
                        [
                            'name' => '_method',
                            'contents' => 'PUT'
                        ],
                        [
                            'name' => 'privacy',
                            'contents' => $request->privacy
                        ],
                        [
                            'name' => 'photo_description',
                            'contents' => $request->photo_description
                        ]
                    ]
            ]);
        }        
        catch(BadResponseException $ex)
        {
            $data = json_decode($ex->getResponse()->getBody()->getContents(), true);
            $errors = [];
            foreach($data as $k=>$v)
                $errors[$k]=$v;
            return redirect('/photos/'.$id.'/edit')->with('error',$errors)->with('photo_id',$id);;
        }
        if($response->getStatusCode() == 200)
        {
            return redirect('/photos/'.$id)->with('success','Photo Successfully Updated');
        }
        else
        {
            return 'Internal Server Error!<br>Check api/albums/create<br>';
        }          
    }

    public function show($id)
    {
        try
        {            
            $req = new Client;            
            try
            {
                if(Auth::check())
                {
                    $response = $req->request('GET',url('/').'/api/photos/'.$id,[
                            'headers' => [
                                'Authorization' => 'Bearer ' . Session::get('access_token'),        
                                'Accept'        => 'application/json',
                            ]
                    ]);
                }
                else
                {
                    $response = $req->request('GET',url('/').'/api/photos/'.$id);
                }
            }        
            catch(BadResponseException $ex)
            {
                if(Auth::check())
                    return redirect('/home')->with('error','Unauthorized');
                else
                    return redirect('/login')->with('error','Unauthorized');
            }
            if($response->getStatusCode() == 200)
            {
                $data = json_decode($response->getBody()->getContents(), true);
                //return $data['data'][0];
                $album = $data['data'][0]['album_id'];
                $user = Album::find($album)->user_id;

                //likes
                $likes = Likes_Photo::where('photo_id',$id)->count();                
                $user_status = -1;
                if(Auth::check())
                {
                    $user_status = Likes_Photo::where('photo_id',$id)->where('user_id',Auth::user()->id)->count();
                }

                return view('photo.photopage')->with('photo',$data['data'][0])->with('user_id',$user)
                        ->with('likes',$likes)->with('user_status',$user_status);
            }
            else
            {
                return 'Internal Server Error!<br>Check api/albums/create<br>';
            }
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try
        {
            $request = new Client;
            try
            {
                $response = $request->request('DELETE',url('/').'/api/photos/'.$id,[
                                'headers' => [
                                    'Authorization' => 'Bearer ' . Session::get('access_token'),        
                                    'Accept'        => 'application/json',
                                ]
                ]);
            }
            catch(BadResponseException $ex)
            {
                return redirect('/home')->with('error','Unauthorized');
            }

            if($response->getStatusCode()==200)
            {
                return redirect('/home')->with('success','Photo Successfully Deleted!');
            }
            else
            {
                return 'Internal Server Error!<br>Check api/albums/delete<br>'.$response;
            } 
            
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //change to ajax calls
    public function like($id)
    {
        try
        {
            $record = Likes_Photo::where('photo_id',$id)
                    ->where('user_id',Auth::user()->id)->count();
            if($record !== 0)
                return redirect('/photos/'.$id)->with('error','Already liked');
            
            Likes_Photo::create(['user_id'=>Auth::user()->id,
                                'photo_id'=>$id]);
            return redirect('/photos/'.$id);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
    
    //change to ajax calls
    public function unlike($id)
    {
        try
        {
            $record = Likes_Photo::where('photo_id',$id)
                    ->where('user_id',Auth::user()->id)->count();
            if($record === 0)
                return redirect('/photos/'.$id)->with('error','Not liked');


            $record = Likes_Photo::where('photo_id',$id)
                ->where('user_id',Auth::user()->id)->delete();
            return redirect('/photos/'.$id);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}