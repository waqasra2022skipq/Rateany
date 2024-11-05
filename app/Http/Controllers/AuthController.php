<?php

namespace App\Http\Controllers;

use App\Models\Profession;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Cache;



class AuthController extends Controller
{
    public function loginForm()
    {
        return view('user.login');
    }

    public function createForm()
    {
        $professions = Cache::remember('professions', 60 * 60, function () {
            return Profession::all();
        });
        return view('user.register', [
            'professions' => $professions
        ]);
    }

    // Logout the user
    public function logout(Request $request)
    {
        FacadesAuth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with("Message", "Logged out Successfully");
    }

    // User Logging IN
    public function login(Request $request)
    {
        $userFields =  $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        if (FacadesAuth::attempt($userFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('Message', 'Successfully Logged IN');
        }

        return back()->withErrors(['email' => "Please Provide correct creds"])->onlyInput('email');
    }
}
