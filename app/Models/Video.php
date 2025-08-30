<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
	use HasFactory;

	protected $connection = 'mysql2';

	protected $fillable = [
		'title',
		'original_name',
		'file_name',
		'mime_type',
		'size_bytes',
		'path',
		'url',
	];
}

