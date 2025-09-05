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
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 191)->unique();
            $table->timestamp('emal_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('avatar_url', 255)->nullable();
            $table->string('bio', 160)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_login_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
