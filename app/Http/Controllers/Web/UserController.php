<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function login(Request $request)
    {
        $req = Request::create('/api/login/','POST',
                                    request()->all(),[],[],$_SERVER);
        $response = app()->handle($req);
        if($response->status() === 200)
        {            
            $data = json_decode($response->content(),true);
            Session::put('access_token',$data['token']);
            return view('pages.success')->with('message','Successfully Logged in');
        }
        else if($response->status() === 401)
        {
            return view('auth.login')->with('error',[['Unauthorized']]);
        }
        else
        {
            return 'Internal Server Error!<br>Check api/login<br>'.$response;
        }
    }
    
    public function register(Request $request)
    {
        try
        {
            $req = new Client;
            $response = $req->request('POST',url('/').'/api/users',[
                    'multipart' => [
                        [
                            'name' => 'first_name',
                            'contents' => $request->first_name
                        ],
                        [
                            'name' => 'last_name',
                            'contents' => $request->last_name
                        ],
                        [
                            'name' => 'profile_picture',
                            'contents' => ($request->file('profile_picture') === null)?'':fopen($request->file('profile_picture'), 'r'),
                            'filename' => ($request->file('profile_picture') === null)?'':$request->file('profile_picture')->getClientOriginalName()
                        ],
                        [
                            'name' => 'gender',
                            'contents' => $request->gender
                        ],
                        [
                            'name' => 'password',
                            'contents' => $request->password
                        ],
                        [
                            'name' => 'password_confirmation',
                            'contents' => $request->password_confirmation
                        ],
                        [
                            'name' => 'username',
                            'contents' => $request->username
                        ],
                        [
                            'name' => 'email',
                            'contents' => $request->email
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
            return view('auth.register')->with(['error'=>$errors]);
        }
        if($response->getStatusCode() == 201)
        {
            return view('auth.login')->with(['message' => 'Successfully Registered']);
        }
        else
        {
            return 'Internal Server Error!<br>Check api/users/create<br>'.$response;
        }    
    }

    public function index()
    {
        try
        {
            $request_user = Request::create('/api/users','GET',
                                            [],
                                            [],[], $_SERVER); 
            $response = app()->handle($request_user);
            if($response->status()==200)
            {
                $data = json_decode($response->content(),true);
                
                return view('pages.users')->with('users',$data['users']);
            }
            else
            {
                return 'Internal Server Error!<br>Check api/users/create<br>'.$response;
            }            
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function myaccount()
    {
        try
        {
            $request = Request::create('/api/users/'.Auth::user()->username,'GET',
                                        [],
                                        [],[], $_SERVER);
            $response = app()->handle($request);
            if($response->status() == 200)
            {
                $data = json_decode($response->content(), true);
                
                return view('pages.myaccount')->with('data',$data['data'][0]);
            }
            else if($response->status() == 404)
            {
                return view('pages.error')->with('message','User not found');
            }
            else
            {
                return 'Internal Server Error!<br>Check api/users/show<br>'.$response;
            } 
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try
        {
            $request_user = Request::create('/api/users/'.$id,'GET',
                                            [],
                                            [],[], $_SERVER); 
            $response = app()->handle($request_user);
            
            if($response->status()==200)
            {
                $data = json_decode($response->content(),true);
                
                return view('user.userpage')->with('user',$data['data'][0])
                        ->with('albums',$data['albums']);
            }
            else if($response->status() == 404)
            {
                return view('pages.error')->with('message','User not found');
            }
            else
            {
                return 'Internal Server Error!<br>Check api/users/show<br>'.$response;
            }            
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }

    }

    public function edituser($id)
    {
        if(Auth::check() and Auth::user()->username === $id)
            return view('user.edituser');
        else
            return view('pages.unauth');//->with('message','Unauthorized');
    }
    public function edit(Request $request, $id)
    {
        try
        {
            $req = new Client;
            $response = $req->request('POST',url('/').'/api/users/'.$id,[
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ],
                    'multipart' => [
                        [
                            'name' => 'first_name',
                            'contents' => $request->first_name
                        ],
                        [
                            'name' => 'last_name',
                            'contents' => $request->last_name
                        ],
                        [
                            'name' => 'profile_picture',
                            'contents' => ($request->file('profile_picture') === null)?'':fopen($request->file('profile_picture'), 'r'),
                            'filename' => ($request->file('profile_picture') === null)?'':$request->file('profile_picture')->getClientOriginalName()
                        ],
                        [
                            'name' => 'gender',
                            'contents' => $request->gender
                        ],
                        [
                            'name' => 'password',
                            'contents' => $request->password
                        ],
                        [
                            'name' => 'password_confirmation',
                            'contents' => $request->password_confirmation
                        ],
                        [
                            'name' => 'email',
                            'contents' => $request->email
                        ],
                        [
                            'name' => '_method',
                            'contents' => 'PUT'
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
            return view('user.edituser')->with(['error'=>$errors]);
        }
        if($response->getStatusCode() == 200)
        {
            return view('pages.unauth')->with(['message' => 'Successfully Edited']);
        }
        else
        {
            return 'Internal Server Error!<br>Check api/users/edit<br>'.$response;
        }            
    }

    public function delete($id)
    {
        try
        { 
            $request = new Client;
            $response = $request->request('DELETE',url('/').'/api/users/'.$id,[
                                        'headers' => [
                                            'Authorization' => 'Bearer ' . Session::get('access_token'),        
                                            'Accept'        => 'application/json',
                                        ]
            ]);
            if($response->getStatusCode()==200)
            {
                return redirect('/login')->with('error',[['Successfully Deleted!']]);
            }
            else if($response->getStatusCode() == 401)
            {
                return view('pages.unauth')->with('message','Not authorized');
            }
            else if($response->getStatusCode() == 404)
            {
                return view('pages.error')->with('message','User not found');
            }
            else
            {
                return 'Internal Server Error!<br>Check api/users/show<br>'.$response;
            } 
            
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
