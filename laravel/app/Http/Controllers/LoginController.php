<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $auth = [
            'email' => $request['username'],
            'password' => $request['password']
        ];
        if (Auth::attempt($auth)) {
            $user = Auth::user();
            $resArr['token'] = $user->createToken('api-application')->accessToken;
            $resArr['name'] = $user->name;
            return response()->json($resArr, 200);
        } else {
            return response()->json(['error' => "unAuthorised Access"], 203);
        }
    }
}
