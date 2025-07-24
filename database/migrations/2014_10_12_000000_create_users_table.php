<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('register_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('citizen')->nullable();
            $table->string('sex')->nullable();
            $table->string('role')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            'email' => 'dev@moscap.mn',
            'password' => '$2y$10$9Ck6IaEdVDHWNOKX7cN8QuSIuQOKAMtC5qAs28IsFOeK5dbyQOGbe',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '+976 99119911',
            'citizen' => 'mongolia',
            'sex' => 'female',
            'register_number' => 'AA99119911',
            'role' => 'admin',
        ]);
        
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
