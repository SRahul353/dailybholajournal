<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'reader') {
                return redirect()->route('home');
            }
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            return \App\Http\Controllers\Auth\SocialAuthController::handlePostLoginRedirect($user);
        }

        return back()->withErrors([
            'email' => 'আপনার প্রদানকৃত ইমেইল বা পাসওয়ার্ডটি সঠিক নয়।',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'সফলভাবে লগআউট হয়েছে।');
    }
}
