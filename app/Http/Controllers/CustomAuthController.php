<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CustomAuthController extends Controller
{
    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        // Validate input data
        $credentials = $request->only('email', 'password');
        
        $request->validate([
            'email' => 'required|email|exists:users,email', // Ensure the email exists in the database
            'password' => 'required|string|min:8', // Ensure password is provided and has at least 8 characters
        ]);

        if (Auth::attempt($credentials)) {
            // Redirect user to their intended page or dashboard
            return redirect()->intended('/');
        }

        // Flash error message to the session
        return back()->with('error', 'Invalid credentials')->withInput();
    }


    // Show Registration Form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        // Validate input data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Please enter a valid email address!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters!',
            'password.confirmed' => 'Passwords do not match!',
        ]);

        // Create new user
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            return back()->with(
                'success', 'Registration successful!');
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage()); // Log error for debugging
            return back()->with('error', 'Registration failed. Please try again.')->withInput();
        }

    }


    // Logout User
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
