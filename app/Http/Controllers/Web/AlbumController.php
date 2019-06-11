<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;

use App\Album;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function createAlbum()
    {
        return view('album.createalbum');
    }

    public function create(Request $request)
    {
        $req = new Client;
        
        try
        {
            $response = $req->request('POST',url('/').'/api/albums',[
                    'form_params' => [
                        'album_name' => $request->album_name,
                        'album_description' => $request->album_description,
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
            return view('album.createalbum')->with(['error'=>$errors]);
        }
        if($response->getStatusCode() == 201)
        {
            return view('home')->with(['message' => 'Album Successfully Created']);
        }
        else
        {
            return 'Internal Server Error!<br>Check api/albums/create<br>';
        }  
    }
    public function editalbum($id)
    {
        $album = Album::find($id);
        if($album == null or Auth::guest() or Auth::user()->id!==$album->user_id)
            return view('home')->with('message','Unauthorized');
        else
            return view('album.editalbum')->with('album_id',$id)->with('album_name',$album->album_name);            
    }

    public function edit(Request $request, $id)
    {
        $req = new Client;            
        try
        {
            $response = $req->request('PUT',url('/').'/api/albums/'.$id,[
                    'form_params' => [
                        'album_name' => $request->album_name,
                        'album_description' => $request->album_description,
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
            return view('album.createalbum')->with(['error'=>$errors]);
        }
        if($response->getStatusCode() == 200)
        {
            return view('home')->with(['message' => 'Album Successfully Updated']);
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
                    $response = $req->request('GET',url('/').'/api/albums/'.$id,[
                            'headers' => [
                                'Authorization' => 'Bearer ' . Session::get('access_token'),        
                                'Accept'        => 'application/json',
                            ]
                    ]);
                }
                else
                {
                    $response = $req->request('GET',url('/').'/api/albums/'.$id);
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
                //return $data['photos'];
                return view('album.albumpage')->with('album',$data['data'][0])->with('photos',$data['photos']);
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
                $response = $request->request('DELETE',url('/').'/api/albums/'.$id,[
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
