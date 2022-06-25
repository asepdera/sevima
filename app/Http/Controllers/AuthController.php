<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;

class AuthController extends Controller
{
    public function login(Request $request){
        //validation with redirect
        $validate = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $credentials = $request->only('email', 'password');
        if (\Auth::attempt($credentials) && \Auth::user()->role == 'teacher') {
            return redirect()->intended('teacher');
        } else if(\Auth::attempt($credentials) && \Auth::user()->role == 'student') {
            return redirect()->intended('student');
        } 

        return redirect()->back()->with('error', 'These credentials do not match our records.',);
    }

    public function register(Request $request){
        $name = $request->input('username');
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));
        $phone = $request->input('phone');
        $role = $request->input('role');

        $validate = $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'username' => 'required',
            'phone' => 'required|unique:user_details'
        ]);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);

        $userDetail = UserDetail::create([
            'user_id' => $user->id,
            'phone' => $phone,
        ]);

        return redirect()->route('login');
    }

    public function logout(){
        \Auth::logout();
        return redirect()->route('login');
    }
}
