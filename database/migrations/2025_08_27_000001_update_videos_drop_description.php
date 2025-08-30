<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	protected $connection = 'mysql2';
	public function up()
	{
		Schema::table('videos', function (Blueprint $table) {
			if (Schema::hasColumn('videos', 'description')) {
				$table->dropColumn('description');
			}
		});
	}

	public function down()
	{
		Schema::table('videos', function (Blueprint $table) {
			if (!Schema::hasColumn('videos', 'description')) {
				$table->text('description')->nullable();
			}
		});
	}
};

