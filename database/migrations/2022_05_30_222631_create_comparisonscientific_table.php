<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComparisonscientificTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comparisonscientific', function (Blueprint $table) {
            $table->id();
            $table->string('name',350);
            $table->string('city',350);
            $table->integer('avg')->default(0);
            $table->integer('maxStudentsNumber')->default(0);
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
        Schema::dropIfExists('comparisonscientific');
    }
}
