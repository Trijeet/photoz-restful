<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;

use App\Album;
use App\Likes_album;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }
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
                    /*'form_params' => [
                        'album_name' => $request->album_name,
                        'album_description' => $request->album_description,
                        'privacy' => $request->privacy,
                    ],*/
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ],
                    'multipart' => [
                        [
                            'name' => 'album_name',
                            'contents' => $request->album_name
                        ],
                        [
                            'name' => 'cover_picture',
                            'contents' => ($request->file('cover_picture') === null)?'':fopen($request->file('cover_picture'), 'r'),
                            'filename' => ($request->file('cover_picture') === null)?'':$request->file('cover_picture')->getClientOriginalName()
                        ],
                        [
                            'name' => 'privacy',
                            'contents' => $request->privacy
                        ],
                        [
                            'name' => 'album_description',
                            'contents' => $request->album_description
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
            return redirect('/albums/create')->with('error',$errors);
            //return view('album.createalbum')->with(['error'=>$errors]);
        }
        if($response->getStatusCode() == 201)
        {
            return redirect('/home')->with('success','Album Successfully Created');
            //return view('pages.success')->with(['message' => 'Album Successfully Created']);
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
            return redirect('/home')->with('error','Not Available or Unauthorized');
        else
            return view('album.editalbum')->with(session(['album_id'=>$id, 'album_name'=>$album->album_name]))
                ->with('album',$album);            
    }

    public function edit(Request $request, $id)
    {
        //dd($request);
        $req = new Client;            
        try
        {
            $response = $req->request('POST',url('/').'/api/albums/'.$id,[
                    /*'form_params' => [
                        'album_name' => $request->album_name,
                        'album_description' => $request->album_description,
                        'privacy' => $request->privacy,
                    ],*/
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ],
                    'multipart' => [
                        [
                            'name' => 'album_name',
                            'contents' => $request->album_name
                        ],
                        [
                            'name' => '_method',
                            'contents' => 'PUT'
                        ],
                        [
                            'name' => 'cover_picture',
                            'contents' => ($request->file('cover_picture') === null)?'':fopen($request->file('cover_picture'), 'r'),
                            'filename' => ($request->file('cover_picture') === null)?'':$request->file('cover_picture')->getClientOriginalName()
                        ],
                        [
                            'name' => 'privacy',
                            'contents' => $request->privacy
                        ],
                        [
                            'name' => 'album_description',
                            'contents' => $request->album_description
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
            
                
            $album = Album::find($id);
            //return view('album.editalbum')->with(['error'=>$errors])
            //   ->with('album_id',$id)->with('album_name',$album->album_name);;
            return redirect('/albums/'.$id.'/edit')->with('error',$errors)
                ->with('album_id',$id)->with('album_name',$album->album_name);;
        }
        if($response->getStatusCode() == 200)
        {
            return redirect('/albums/'.$id)->with('success','Album Successfully Updated');
            //return view('pages.success')->with(['message' => 'Album Successfully Updated']);
        }
        else
        {
            return 'Internal Server Error!<br>Check api/albums/create<br>';
        }            
    }

    public function show($id)
    {
        $album = Album::where('id','=',$id);
       
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
                if(Auth::check())
                    return redirect('/home')->with('error','Unauthorized');
                else
                    return redirect('/login')->with('error','Unauthorized');
            }
            if($response->getStatusCode() == 200)
            {
                $data = json_decode($response->getBody()->getContents(), true);

                $likes = Likes_album::where('album_id',$id)->count();
                
                $user_status = -1;
                if(Auth::check())
                {
                    $user_status = Likes_album::where('album_id',$id)->where('user_id',Auth::user()->id)->count();
                }

                return view('album.albumpage')->with('album',$data['data'][0])->with('photos',$data['photos'])
                        ->with('likes',$likes)->with('user_status',$user_status);
            }
            else
            {
                return 'Internal Server Error!<br>Check api/albums/show<br>';
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
                //return view('pages.unauth');//->with(['message'=>'Unauthorized']);
                return redirect('/home')->with('error','Unauthorized');
            }

            if($response->getStatusCode()==200)
            {
                //return view('pages.success')->with('message','Album Successfully Deleted!');
                return redirect('/home')->with('success','Album Successfully Deleted!');
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

    public function like($id)
    {
        //return 'like album '.$id;
        try
        {
            $record = Likes_album::where('album_id',$id)
                    ->where('user_id',Auth::user()->id)->count();
            if($record !== 0)
                return redirect('/albums/'.$id)->with('error','Already liked');
            
            Likes_album::create(['user_id'=>Auth::user()->id,
                                'album_id'=>$id]);
            return redirect('/albums/'.$id);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function unlike($id)
    {
        //return 'un  like album';
        try
        {
            $record = Likes_album::where('album_id',$id)
                    ->where('user_id',Auth::user()->id)->count();
            if($record === 0)
                return redirect('/albums/'.$id)->with('error','Not liked');


            $record = Likes_album::where('album_id',$id)
                        ->where('user_id',Auth::user()->id)->delete();
            return redirect('/albums/'.$id);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
