<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $req){
        $user = \App\Models\User::where('email',$req->login_email)->first();
        if($user){
            return redirect('/home');
        }
        return redirect()->back()->with('error', 'Email or Password is incorrect');
    }
}
