<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Login(){
        return view('auth.login');
    }

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt to authenticate using the user's email
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return redirect()->route('calendar');
        }
       
        // If none of the attempts succeed, redirect back with an error message
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
    }
    public function cPassword(){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to change your password.');
        }
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Pass the user information to the view
        return view('auth.changepass', ['user' => $user]);
    }

    public function changePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to change your password.');
        }
    
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|same:confirm_password',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ]);
    
        $user = Auth::user();
    
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('dashboard')->with('success', 'Password changed successfully.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
