<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use GuzzleHttp\Client;
use Auth;
use App\User;
use App\Album;

class PagesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('prevent-back-history');
    }


    public function about()
    {
        return view('pages.about');
    }
    public function users()
    {
        // Use API Request -> api/users
        $users = User::orderBy('created_at','asc')->paginate(10);
        //$request = Request::create('/api/users/','GET');
        //$response = app()->handle($request);
        
        //$json_response = $response->getContent();

        //$users = json_decode($json_response,true)['users'];
        //$users = collect($users);

        /*$client = new Client([
            'base_uri' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);
        $request = $client->get('http://localhost:8000/api/users');
        $response = $request->getBody();
        return $response;*/

        return view('pages.users')->with('users',$users);
    }
    public function myaccount()
    {
        if(Auth::check())// API -> api/users/{user_id} with Auth
            return view('pages.myaccount');   
        else
            return redirect('/login');
        
    }
    public function unauthorized()
    {
        return view('pages.unauthorized');        
    }
    public function error()
    {
        return view('pages.error');        
    }

    public function register()
    {
        //return 'Register';
        return view('pages.register');
    }    
}
