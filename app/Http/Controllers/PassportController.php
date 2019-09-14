<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PassportController extends Controller
{
    
    /**
     * Handles Home Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['message' => "Register at '/api/register' | Login at '/api/login'"], 200);
    }

    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
     
            if($validator->fails())
            {
                $error = $validator->errors()->first();
                return response()->json(['success'  => false, 'message' => $error], 400);
            }

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password'])
            ]);
     
            $token = $user->createToken(env("APP_API_KEY", "article-api"))->accessToken;
     
            return response()->json(['token' => $token], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'  => false, 'message' => $e->getMessage()], 400);
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
                'email' => $request->email,
                'password' => $request->password
            ];
     
            if (auth()->attempt($credentials)) {
                $token = auth()->user()->createToken(env("APP_API_KEY", "article-api"))->accessToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'UnAuthorised'], 401);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        try{
            return response()->json(['user' => auth()->user()], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['message' => $e.getMessage()], 500);
        }
        // return json_encode(auth()->user());
    }
}
