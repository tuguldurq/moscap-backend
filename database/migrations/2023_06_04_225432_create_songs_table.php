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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('song_code')->nullable();
            $table->string('a_iswc')->nullable();
            $table->string('c_iswc')->nullable();
            $table->string('origin_name');
            $table->string('english_name')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('composer_id')->nullable();
            $table->foreign('author_id')->references('id')->on('artists');
            $table->foreign('composer_id')->references('id')->on('artists');
            $table->string('performer')->nullable();
            $table->string('year')->nullable();
            $table->string('category')->nullable();
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
        Schema::dropIfExists('songs');
    }
};
