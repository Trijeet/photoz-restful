<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;

use App\Album;
use App\Photo;

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
            return view('home')->with('message','Unauthorized');
        else
            return view('photo.uploadphoto')->with('id',$id);
    }

    public function create(Request $request)
    {
        $req = new Client;
        try
        {   
            //dd($request);
            $response = $req->request('POST',url('/').'/api/photos',[
                    /*'form_params' => [
                        'album_id' => $request->album_id,
                        'photo_description' => $request->photo_description,
                        'privacy' => $request->privacy,
                    ],*/
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
                            'contents' => ($request->file('photo') === null)?'':fopen($request->file('photo'), 'r')
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
            return view('photo.uploadphoto')->with(['error'=>$errors])->with('id',$request->album_id);
        }
        if($response->getStatusCode() == 201)
        {
            return view('home')->with(['message' => 'Photo Successfully Uploaded']);
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
            return view('home')->with('message','No Such Photo');
        $album = Album::find($photo->album_id);
        if($album == null or Auth::guest() or Auth::user()->id!==$album->user_id)
            return view('home')->with('message','Unauthorized');
        else
            return view('photo.editphoto')->with('album_id',$photo->album_id)
                ->with('photo_id',$id);            
    }

    public function edit(Request $request, $id)
    {
        $req = new Client;            
        try
        {
            $response = $req->request('PUT',url('/').'/api/photos/'.$id,[
                    'form_params' => [
                        'photo_description' => $request->photo_description,
                        'privacy' => $request->privacy,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ]
            ]);
        }        
        catch(BadResponseException $ex)
        {
            $data = json_decode($ex->getResponse()->getBody()->getContents(), true);
            $errors = [];
            foreach($data as $k=>$v)
                $errors[$k]=$v;
            return view('photo.editphoto')->with(['error'=>$errors])->with('album_id',$photo->album_id)
                        ->with('photo_id',$id);;
        }
        if($response->getStatusCode() == 200)
        {
            return view('home')->with(['message' => 'Photo Successfully Updated']);
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
                //return $ex->getResponse();
                return view('home')->with(['message'=>'Unauthorized']);
            }
            if($response->getStatusCode() == 200)
            {
                $data = json_decode($response->getBody()->getContents(), true);
                //return $data['data'][0];
                $album = $data['data'][0]['album_id'];
                $user = Album::find($album)->user_id;
                return view('photo.photopage')->with('photo',$data['data'][0])->with('user_id',$user);
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
                return view('home')->with(['message'=>'Unauthorized']);
            }

            if($response->getStatusCode()==200)
            {
                return redirect('home')->with('message','Successfully Deleted!');
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
}