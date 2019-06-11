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

    public function login(Request $request)
    {
        $req = Request::create('/api/login/','POST',
                                    request()->all(),[],[],$_SERVER);
        $response = app()->handle($req);
        if($response->status() === 200)
        {            
            $data = json_decode($response->content(),true);
            Session::put('access_token',$data['token']);
            return view('home')->with('message','Successfully Logged in');
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
            if($request->hasFile('profile_picture'))
            {
                $request_user = Request::create('/api/users/','POST',
                                                request()->all(),
                                                [],[$request->file('profile_picture')], $_SERVER); 
            }
            else
            {
                $request_user = Request::create('/api/users/','POST',
                                                request()->all(),
                                                [],[], $_SERVER);
            }
            $response = app()->handle($request_user);
            if($response->status() == 400)
            {
                $r = $response->content();                
                $data = json_decode($r);
                $errors = [];
                foreach($data as $k=>$v)
                    $errors[$k]=$v;

                return view('auth.register')->with(['error'=>$errors]);

            }
            else if($response->status() == 201)
            {
                return view('auth.login')->with(['message' => 'Successfully Registered']);
            }
            else
            {
                return 'Internal Server Error!<br>Check api/users/create<br>'.$response;
            }            
         
        } catch (\Exception $e)
        {
        
            return response()->json(['success' => false,
                                    'message' => $e->getMessage()], 500);
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
                return view('pages.myaccount')->with('message','User not found');
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
                return view('pages.users')->with('message','User not found');
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
            return view('home')->with('message','Unauthorized');
    }
    public function edit(Request $request, $id)
    {
        $req = new Client;
        try
        {
            $response = $req->request('PUT',url('/').'/api/users/'.$id,[
                    'form_params' => [
                        'first_name' => $request->first_name,
                        'email' => $request->email,
                        'last_name' => $request->last_name,
                        'gender' => $request->gender,
                        'password' => $request->password,
                        'password_confirmation' => $request->password_confirmation,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('access_token'),        
                        'Accept'        => 'application/json',
                    ],
                    /*'multipart' => [
                        'name' => 'profile_picture',
                        'contents' => fopen($request->profile_picture,'r')
                    ]*/
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
            return view('home')->with(['message' => 'Successfully Edited']);
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
                return view('home')->with('message','Not authorized');
            }
            else if($response->getStatusCode() == 404)
            {
                return view('home')->with('message','User not found');
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
