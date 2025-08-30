<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql2')->hasTable('no_antrian')) {
            Schema::connection('mysql2')->create('no_antrian', function (Blueprint $table) {
                $table->id();
                $table->string('no_urut');
                $table->string('ketegori');
                $table->unsignedBigInteger('status');
                $table->date('post_date');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('no_antrian');
        // Schema::dropIfExists('no_antrian');
    }
};
