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
            $table->text('comment');
            $table->string('psid')->nullable();
            $table->string('steamid')->nullable();
            $table->string('originid')->nullable();
            $table->string('skypeid')->nullable();
            $table->string('discordid')->nullable();
            $table->string('friend_code')->nullable();
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
