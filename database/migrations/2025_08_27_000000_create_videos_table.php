<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	protected $connection = 'mysql2';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function (Blueprint $table) {
			$table->id();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->string('original_name');
			$table->string('file_name');
			$table->string('mime_type')->nullable();
			$table->unsignedBigInteger('size_bytes')->default(0);
			$table->string('path');
			$table->string('url');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('videos');
	}
};

