<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEquipmentPlant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_equipment_plant', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_equipment_code_id')->unsigned();
            $table->foreign('tbl_equipment_code_id')->references('id')
                  ->on('tbl_equipment_code')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_plant_id')->unsigned();
            $table->foreign('tbl_plant_id')->references('id')
                  ->on('tbl_plant')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('tbl_equipment_code_id', 'tbl_plant_id'));

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
        Schema::dropIfExists('tbl_equipment_plant');
    }
}
