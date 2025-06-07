<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Login as LoginModel;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Rol;

class Login extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Only login if both email and password match a user
        $user = LoginModel::where('email', $request->email)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
            // Check if user role is Admin or Super Admin
            $roleName = optional($user->rol)->name;
            if ($roleName === 'Admin' || $roleName === 'Super Admin') {
                Auth::login($user);
                return redirect()->intended('/admin/dashboard');
            } else {
                return back()->withErrors([
                    'email' => 'Access denied. Only Admin or Super Admin can login.',
                ])->withInput($request->except('password'));
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput($request->except('password'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = LoginModel::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Assign default role (e.g., Admin) or handle as needed
                $adminRole = Rol::whereIn('name', ['Admin', 'Super Admin'])->first();
                if (!$adminRole) {
                    return redirect()->route('admin.login')->withErrors(['email' => 'No admin role found.']);
                }
                $user = LoginModel::create([
                    'email' => $googleUser->getEmail(),
                    'password' => '', // No password for Google users
                    'rol_id' => $adminRole->id,
                ]);
            }

            $roleName = optional($user->rol)->name;
            if ($roleName === 'Admin' || $roleName === 'Super Admin') {
                Auth::login($user);
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->route('admin.login')->withErrors(['email' => 'Access denied. Only Admin or Super Admin can login.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Google login failed.']);
        }
    }
}
