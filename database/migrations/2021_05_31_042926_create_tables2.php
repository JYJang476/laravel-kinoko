<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('Users', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('user_id')->unsigned(); // 유저 번호
//            $table->timestamp('user_date')->useCurrent(); // 프로그램 번호
//            $table->timestamp('user_lastlogout'); // 핀 번호
//            $table->integer('user_machineid')->unsigned(); // 가동 상태
//            $table->string('token', 50)->nullable(); // 기기 아이피
//        });

//        Schema::create('Machines', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('machine_userid')->unsigned(); // 유저 번호
//            $table->integer('machine_prgid'); // 프로그램 번호
//            $table->integer('machine_pin'); // 핀 번호
//            $table->string('machine_ison', 5)->default('false'); // 가동 상태
//            $table->string('machine_ip', 18)->nullable(); // 기기 아이피
//            $table->string('machine_ispresence', 5)->default('false'); // 배지 유무
//            $table->string('machine_name', 30);
////            $table->foreign("machine_userid")->references('id')->on('Users')->onDelete('cascade');
//        });
//
//        Schema::create('Pins', function (Blueprint $table) {
//            $table->integer('pin_value');
//            $table->integer('pin_machineid')->unsigned();
//            $table->string('pin_pw', 16);
//            $table->primary('pin_value');
//            $table->foreign("pin_machineid")->references('id')->on('Machines')->onDelete('cascade');
//        });

        Schema::create('Programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prg_userid')->unsigned();
            $table->integer('prg_machineid');
            $table->integer('prg_dateid');
            $table->string('prg_name', 30)->nullable();
            $table->string('prg_type', 15);
            $table->integer('prg_water');
            $table->integer('prg_sunshine');
            $table->integer('prg_count');
            $table->string('prg_compostname', 30)->nullable();
            $table->integer("prg_period");
            $table->foreign("prg_userid")->references('id')->on('Users')->onDelete('cascade');
        });

        Schema::create('Mushrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mr_prgid')->unsigned();
            $table->integer('mr_size');
            $table->integer('mr_imgid');
            $table->integer('mr_growthrate');
            $table->string('mr_status', 15)->default('growing');
            $table->foreign("mr_prgid")->references('id')->on('Programs')->onDelete('cascade');
        });

        Schema::create('Dates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('date_userid')->unsigned();
            $table->timestamp("date_start")->nullable();
            $table->timestamp("date_end")->useCurrent();
            $table->foreign("date_userid")->references('id')->on('Users')->onDelete('cascade');
        });

        Schema::create('Growth_Rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gr_userid')->unsigned();
            $table->integer('gr_prgid');
            $table->integer('gr_value');
            $table->foreign("gr_userid")->references('id')->on('Users')->onDelete('cascade');
        });

        Schema::create('Compost_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("compostimg_userid")->unsigned();
            $table->string('compostimg_url', 100);
            $table->integer("compostimg_date");
            $table->foreign("compostimg_userid")->references('id')->on('Users')->onDelete('cascade');
        });

        Schema::create('Mushroom_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("mushimg_mrid")->unsigned();
            $table->string('mushimg_url', 100);
            $table->integer("mushimg_date");
            $table->foreign("mushimg_mrid")->references('id')->on('Mushrooms')->onDelete('cascade');
        });

        Schema::create('Setting_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("setting_prgid")->unsigned();
            $table->integer("setting_value");
            $table->string("setting_type", 12);
            $table->timestamp("setting_date")->nullable();
            $table->foreign("setting_prgid")->references('id')->on('Users')->onDelete('cascade');
        });

        Schema::create('token', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_no')->unsigned();
            $table->timestamp('date')->useCurrent();
            $table->string('token', 60);
            $table->foreign('user_no')->references('id')->on('Users')->onDelete('cascade');
        });

        Schema::create('Help', function (Blueprint $table) {
            $table->id();
            $table->string("name", 20);
            $table->string("effect", 500);
            $table->string("environment", 500);
            $table->string("thumnail_url", 200)->nullable();
            $table->timestamp("date")->useCurrent();
        });

        Schema::create('help_image', function (Blueprint $table) {
            $table->id();
            $table->string("url");
            $table->timestamp("date")->useCurrent();
        });

        Schema::create('3ddata', function (Blueprint $table) {
            $table->id();
            $table->string('url', 50);
            $table->integer('machineid')->unique();
            $table->timestamp('date')->useCurrent();
        });

        Schema::create('Datas', function (Blueprint $table) {
            $table->id();
            $table->integer('prgid');
            $table->integer('value');
            $table->string('type', 12);
            $table->timestamp('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables2');
    }
}
