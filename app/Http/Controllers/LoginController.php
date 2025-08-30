<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function showLogin()
	{
		return view('auth.login');
	}

	public function login(Request $request)
	{
		$credentials = $request->validate([
			'username' => 'required|string',
			'password' => 'required|string',
		]);

		// Simple demo auth: compare to env or fixed values
		$validUser = env('APP_LOGIN_USER', 'admin');
		$validPass = env('APP_LOGIN_PASS', 'admin');

		if ($credentials['username'] === $validUser && $credentials['password'] === $validPass) {
			$request->session()->put('auth_username', $credentials['username']);
			return redirect()->intended('/');
		}

		return back()->withErrors(['username' => 'Login gagal'])->withInput();
	}

	public function logout(Request $request)
	{
		$request->session()->forget('auth_username');
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/login');
	}
}

