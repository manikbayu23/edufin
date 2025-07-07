<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return in_array(Auth::user()->role, ['admin']) ? redirect()->route('admin.dashboard') : redirect('user.dashboard'); // Ubah ke route tujuan
        }
        return view('pages.auth.login');
    }
    public function adminLogin()
    {
        if (Auth::check()) {
            return in_array(Auth::user()->role, ['admin']) ? redirect()->route('admin.dashboard') : redirect('user.dashboard'); // Ubah ke route tujuan
        }
        return view('pages.auth.admin-login');
    }
    public function do_login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']])) {
            return in_array(Auth::user()->role, ['admin'])
                ? redirect()->route('admin.dashboard')
                : redirect('user.dashboard');
        }

        return back()->withErrors([
            'failed' => 'Email atau password salah.',
        ]);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name_reg' => 'required|unique:users,name',
            'email_reg' => 'required|unique:users,email|email',
            'password_reg' => 'required|min:8'
        ], [
            'name_reg.required' => 'Nama wajib diisi',
            'name_reg.unique' => 'Nama sudah terdaftar',
            'email_reg.required' => '_reg wajib diisi',
            'email_reg.unique' => 'Email sudah terdaftar',
            'email_reg.email' => 'Format email salah',
            'password_reg.required' => 'Password wajib diisi',
            'password_reg.min' => 'Password minimal 8 karakter',
        ]);

        User::insert(
            [
                'name' => $validate['name_reg'],
                'email' => $validate['email_reg'],
                'password' => $validate['password_reg'],
                'role' => 'user'
            ]
        );

        return back()->with('success', 'Berhasil daftar akun.');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
