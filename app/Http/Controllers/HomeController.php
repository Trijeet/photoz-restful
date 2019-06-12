<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

use Illuminate\Http\Request;

use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check())
        {
            try
            {
                $req = new Client;
                $response = $req->request('GET',url('/').'/api/users/'.Auth::user()->username,[
                        'headers' => [
                            'Authorization' => 'Bearer ' . Session::get('access_token'),        
                            'Accept'        => 'application/json',
                        ]
                ]);
            }        
            catch(BadResponseException $ex)
            {
                //return $ex->getResponse();
                return redirect('/users')->with('error','Unauthorized');
            }
            if($response->getStatusCode() == 200)
            {
                $data = json_decode($response->getBody()->getContents(), true);
                return view('home')->with('albums',$data['albums']);
            }
            else
            {
                return 'Error';
            }
        }       
        
        return view('home');
    }
}
