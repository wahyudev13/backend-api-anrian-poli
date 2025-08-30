<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Video;

class VideoController extends Controller
{
	public function index(Request $request)
	{
		$query = Video::query()->orderByDesc('created_at');
		$perPage = (int) $request->get('per_page', 15);
		return response()->json($query->paginate($perPage));
	}

	public function showUploadForm(Request $request)
	{
		$perPage = (int) $request->get('per_page', 10);
		$videos = Video::query()->orderByDesc('created_at')->paginate($perPage);
		return view('video.upload', compact('videos'));
	}

	public function upload(Request $request)
	{
		$request->validate([
			'video' => 'required|file|mimetypes:video/mp4|max:204800',
			'title' => 'nullable|string|max:255',
		]);

		$file = $request->file('video');
		$originalName = $file->getClientOriginalName();
		$mimeType = $file->getClientMimeType();
		$sizeBytes = $file->getSize();

		$randomName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
		$path = $file->storeAs('videos', $randomName, 'public');
		$url = Storage::disk('public')->url($path);

		$video = Video::create([
			'title' => $request->input('title'),
			'original_name' => $originalName,
			'file_name' => $randomName,
			'mime_type' => $mimeType,
			'size_bytes' => $sizeBytes,
			'path' => $path,
			'url' => $url,
		]);


		// If the request expects HTML (web), redirect back with status
		if ($request->wantsJson() === false && $request->expectsJson() === false && $request->accepts(['text/html', 'application/xhtml+xml'])) {
			return redirect()->route('videos.upload.form')->with('status', 'Video berhasil diupload. URL: '.$url);
		}

		return response()->json([
			'message' => 'Video uploaded successfully',
			'data' => $video,
		], 201);
	}

	public function destroy(Request $request, Video $video)
	{
		if ($video->path) {
			try {
				Storage::disk('public')->delete($video->path);
			} catch (\Throwable $e) {
				// Ignore file deletion errors; proceed to delete DB record
			}
		}

		$video->delete();

		if ($request->wantsJson()) {
			return response()->json(['message' => 'Video deleted']);
		}

		return redirect()->route('videos.upload.form')->with('status', 'Video berhasil dihapus.');
	}
}

