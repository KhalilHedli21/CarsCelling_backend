<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->enum('role', ['user', 'admin'])->default('user'); // Default role is 'user'
        });
 
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};