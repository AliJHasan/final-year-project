<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName',250);
            $table->string('address',250);
            $table->string('motherName',250);
            $table->string('schoolName',250);
            $table->string('branch',250);
            $table->integer('subscriptionNumber')->unique();
            $table->string('phoneNumber',250)->unique();
            $table->string('password',250);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
