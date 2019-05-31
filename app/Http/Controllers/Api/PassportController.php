<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//Hash::make($request->input('password')
//if(Hash::check($input, $hash))

use App\User;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try
        { 
            $request_user = Request::create('/api/users/','POST',request()->all()); 
            //return $request->input('profile_picture');
            $response = app()->handle($request_user);
            return $response;
        
        } catch (\Exception $e)
        {
        
            return response()->json(['success' => false,
                                    'message' => $e->getMessage()], 500);
        }
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try{

            $credentials = [
                'username' => $request->username,
                'password' => $request->password
            ];
    
            if (auth()->attempt($credentials)) {
                $token = auth()->user()->createToken('Token')->accessToken;
                return response()->json(['success' =>true,
                                        'token' => $token,
                                        'user' => $request->username], 200);
            } else {
                return response()->json(['error' => 'UnAuthorised'], 401);
            }

        }
        catch (\Exception $e)
        {
        
            return response()->json(['success' => false,
                                    'message' => $e->getMessage()], 500);
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        try
        {
            return response()->json(['user' => auth()->user()], 200);
        } catch (\Exception $e)
        {
        
            return response()->json(['success' => false,
                                    'message' => $e->getMessage()], 500);
        }
    }
}
