<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoDisplaySetting;

class VideoDisplaySettingController extends Controller
{
	public function index()
	{
		$settings = VideoDisplaySetting::with('video')->orderBy('display')->orderByDesc('id')->get();
		$videos = Video::orderByDesc('created_at')->get();
		return view('video.display_settings.index', compact('settings', 'videos'));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'id_video' => 'required|exists:mysql2.videos,id',
			'display' => 'required|in:loket,poli-1,poli-2',
		]);

		VideoDisplaySetting::create($data);
		return redirect()->back()->with('status', 'Mapping ditambahkan');
	}

	public function destroy(VideoDisplaySetting $videoDisplaySetting)
	{
		$videoDisplaySetting->delete();
		return redirect()->back()->with('status', 'Mapping dihapus');
	}

	public function getByDisplay(Request $request, string $display)
	{
		$request->validate([
			'display' => 'in:loket,poli-1,poli-2',
		]);

		$settings = VideoDisplaySetting::with('video')
			->where('display', $display)
			->orderByDesc('created_at')
			->get();

		return response()->json([
			'status' => 'ok',
			'data' => $settings,
		]);
	}
}

