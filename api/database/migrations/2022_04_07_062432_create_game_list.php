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
        Schema::create('game', function (Blueprint $table) {
            $table->id();
            $table->string('game_name');
            $table->string('game_image_url')->nullable();
            $table->integer('hardware_id');
            $table->boolean('is_ps')->default(0);
            $table->boolean('is_steam')->default(0);
            $table->boolean('is_origin')->default(0);
            $table->boolean('is_skype')->default(0);
            $table->boolean('is_discord')->default(0);
            $table->boolean('is_friend_code')->default(0);
            $table->boolean('is_invalid')->default(0);
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
        Schema::dropIfExists('game_list');
    }
};
