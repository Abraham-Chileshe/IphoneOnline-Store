<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            \Log::info('User logged in', ['user_id' => Auth::id(), 'ip' => $request->ip()]);
            
            return redirect()->intended('/');
        }

        \Log::warning('Failed login attempt', ['login' => $request->login, 'ip' => $request->ip()]);

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|min:10|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'address' => 'required|string|min:5|max:500',
            'city' => 'required|string|min:2|max:100',
            'postal_code' => 'required|string|min:3|max:20',
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'phone.regex' => 'Phone number format is invalid.',
            'phone.unique' => 'This phone number is already registered.',
        ]);

        try {
            $user = User::create([
                'name' => strip_tags(trim($request->name)),
                'email' => filter_var(trim($request->email), FILTER_SANITIZE_EMAIL),
                'phone' => preg_replace('/[^0-9+\-\s()]/', '', $request->phone),
                'password' => Hash::make($request->password),
                'address' => strip_tags(trim($request->address)),
                'city' => strip_tags(trim($request->city)),
                'postal_code' => strip_tags(trim($request->postal_code)),
                'role' => 'customer',
            ]);

            Auth::login($user);
            
            \Log::info('New user registered', ['user_id' => $user->id, 'email' => $user->email]);

            return redirect('/')->with('success', 'Welcome to our store!');
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
