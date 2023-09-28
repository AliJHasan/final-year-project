<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComparisonresultSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comparisonresult_s', function (Blueprint $table) {
            $table->id();
            $table->integer('subscriptionNumber');
            $table->integer('comparisonId');
            $table->integer('desireId');
            $table->string('status')->default("false");
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
        Schema::dropIfExists('comparisonresult_s');
    }
}
