<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	protected $connection = 'mysql2';

	public function up()
	{
		Schema::create('video_display_settings', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('id_video');
			$table->enum('display', ['loket','poli-1','poli-2']);
			$table->timestamps();

			$table->foreign('id_video')->references('id')->on('videos')->onDelete('cascade');
			$table->index(['id_video', 'display']);
		});
	}

	public function down()
	{
		Schema::dropIfExists('video_display_settings');
	}
};

