<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class ApiKeyAuth
{
	public function handle(Request $request, Closure $next)
	{
		$providedKey = $request->header('X-API-KEY');
		$configKey = config('app.api_key');

		if (!$configKey) {
			$configKey = optional(
				Setting::where('module', 'security')
					->where('field', 'api_key')
					->first()
			)->value;
		}

		if (!$configKey || !$providedKey || !hash_equals((string) $configKey, (string) $providedKey)) {
			return response()->json(['message' => 'Unauthorized'], 401);
		}

		return $next($request);
	}
}

