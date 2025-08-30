<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebAuth
{
	public function handle(Request $request, Closure $next)
	{
		if (!$request->session()->has('auth_username')) {
			return redirect()->guest('/login');
		}

		return $next($request);
	}
}

