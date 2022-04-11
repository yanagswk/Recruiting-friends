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
        Schema::create('recruitment', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id');
            $table->integer('hardware_id');
            $table->text('comment');
            $table->string('ps_id')->nullable();
            $table->string('steam_id')->nullable();
            $table->string('origin_id')->nullable();
            $table->string('skype_id')->nullable();
            $table->string('discord_id')->nullable();
            $table->string('friend_code_id')->nullable();
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
        Schema::dropIfExists('recruitment');
    }
};
