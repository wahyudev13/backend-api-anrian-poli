<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Setting;

class ApiKeyController extends Controller
{
	public function show()
	{
		$current = Setting::where('module', 'security')->where('field', 'api_key')->first();
		$apiKey = $current ? $current->value : null;
		return view('security.api_key', compact('apiKey'));
	}

	public function generate(Request $request)
	{
		$this->authorizeRequest($request);
		$newKey = Str::random(40);
		Setting::updateOrCreate(
			['module' => 'security', 'field' => 'api_key'],
			['value' => $newKey]
		);
		return redirect()->back()->with('status', 'API key diperbarui')->with('api_key', $newKey);
	}

	private function authorizeRequest(Request $request): void
	{
		// Add simple CSRF is already handled by web middleware; nothing else needed here
	}
}

