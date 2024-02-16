<?php

namespace App\Http\Controllers;

use App\Models\LandlordUser as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class LandlordAuthController extends Controller
{
    public function __construct(){
        //add guest middleware to all routes except logout and dashboard
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }
    public function register(){
        return view('landlord.register');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password)
        ]);
        $loginDetails= $request->only('email', 'password');
        Auth::guard('landlord')->attempt($loginDetails);
        $request->session()->regenerate();
        return redirect('/dashboard')->with('message', 'you have registered and logged in successfully');
    }
    public function login(){
        return view('landlord.login');
    }
    public function auth(Request $request)
    {
        $loginDetails = $request->validate([
            'email'=> ['required', 'email'],
            'password' => ['required',]
        ]);
        if (Auth::guard('landlord')->attempt($loginDetails)){
            $request->session()->regenerate();
            return redirect('/dashboard')->with('message', 'you have logged in successfully');
        }
        return back()->with('message', 'Your details dont match in the records')->onlyInput('email');
    }
    public function dashboard(){
        if (Auth::guard('landlord')->check()){
            return view('landlord.dashboard');
        }
        return redirect('/login')->withErrors([
            'message'=> 'login to move access the dashboard'
        ]);
    }

    public function logout(Request $request){
        Auth::guard('landlord')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('message', 'You have been logged out!');
    }


}
