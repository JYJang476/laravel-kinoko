<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddOnDelete extends Migration
{
    /**
     * Run the migrations.
     * Cascade on delete 추가 마이그레이션
     * @return void
     */
    public function up()
    {
        Schema::table('Programs', function (Blueprint $table) {
            $table->foreign("prg_userid")->references('id')->on('Members')->onDelete('cascade');
        });

        Schema::table('Machines', function (Blueprint $table) {
            $table->dropForeign("machines_machine_userid_foreign");
            $table->foreign("machine_userid")->references('id')->on('Members')->onDelete('cascade');
        });

        Schema::table('Dates', function (Blueprint $table) {
            $table->dropForeign("dates_date_userid_foreign");
            $table->foreign("date_userid")->references('id')->on('Members')->onDelete('cascade');
        });

        Schema::table('Growth_rates', function (Blueprint $table) {
            $table->dropForeign("growth_rates_gr_userid_foreign");
            $table->foreign("gr_userid")->references('id')->on('Members')->onDelete('cascade');
        });

        Schema::table('Compost_images', function (Blueprint $table) {
            $table->dropForeign("compost_images_compostimg_userid_foreign");
            $table->foreign("compostimg_userid")->references('id')->on('Members')->onDelete('cascade');
        });

        Schema::table('Mushrooms', function (Blueprint $table) {
            $table->dropForeign("mushrooms_mr_prgid_foreign");
            $table->foreign("mr_prgid")->references('id')->on('Programs')->onDelete('cascade');
        });

        Schema::table('Setting_datas', function (Blueprint $table) {
            $table->dropForeign("setting_datas_setting_prgid_foreign");
            $table->foreign("setting_prgid")->references('id')->on('Programs')->onDelete('cascade');
        });

        Schema::table('Mushroom_images', function (Blueprint $table) {
            $table->dropForeign("mushroom_images_mushimg_mrid_foreign");
            $table->foreign("mushimg_mrid")->references('id')->on('Mushrooms')->onDelete('cascade');
        });

        Schema::table('Pins', function (Blueprint $table) {
            $table->dropForeign("pins_pin_machineid_foreign");
            $table->foreign("pin_machineid")->references('id')->on('Machines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
