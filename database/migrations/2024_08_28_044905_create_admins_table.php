<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name'); // This is for admin or user name
            $table->string('password');
            $table->boolean('is_admin')->default(false); // To distinguish admin users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Admins');
    }
};
