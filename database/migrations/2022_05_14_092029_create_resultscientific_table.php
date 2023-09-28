<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultscientificTable extends Migration
{

    public function up()
    {
        Schema::create('resultscientific', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscriptionNumber')->unique();
            $table->unsignedInteger('arabic')->default(0);
            $table->unsignedInteger('english')->default(0);
            $table->unsignedInteger('france')->default(0);
            $table->unsignedInteger('national')->default(0);
            $table->unsignedInteger('math')->default(0);
            $table->unsignedInteger('physics')->default(0);
            $table->unsignedInteger('chemistry')->default(0);
            $table->unsignedInteger('science')->default(0);
            $table->integer('sum')->default(0);
            $table->unsignedInteger('eslamic')->default(0);
            $table->integer('totalSum')->default(0);
            $table->unsignedInteger('final')->default(0);
            $table->boolean('state')->default(true);
            $table->boolean('privilge')->default(true);
            $table->timestamps();

            $table->foreign('subscriptionNumber')->references('subscriptionNumber')->on('users')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('resultscientific');
    }
}
