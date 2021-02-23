<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Help', function (Blueprint $table) {
            $table->id();
            $table->string("name", 20);
            $table->string("effect", 500);
            $table->string("environment", 500);
            $table->string("thumnail_url", 200)->nullable();
            $table->timestamp("date")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help');
    }
}
