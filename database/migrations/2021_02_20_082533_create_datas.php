<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('Datas', function (Blueprint $table) {
//            $table->id();
//            $table->integer('prgid');
//            $table->integer('value');
//            $table->string('type', 12);
//            $table->timestamp('date')->useCurrent();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Datas');
    }
}
