<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoDisplaySetting extends Model
{
	use HasFactory;

	protected $connection = 'mysql2';
	protected $table = 'video_display_settings';

	protected $fillable = [
		'id_video',
		'display',
	];

	public function video()
	{
		return $this->belongsTo(Video::class, 'id_video');
	}
}

