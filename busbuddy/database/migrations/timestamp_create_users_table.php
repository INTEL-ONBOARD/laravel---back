<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('contact')->nullable();
            $table->text('bio')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('password');
            $table->timestamps();
        });
    }
    

};
