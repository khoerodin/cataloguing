<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartEquipmentCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_equipment_code', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_equipment_code_id')->unsigned();
            $table->foreign('tbl_equipment_code_id')->references('id')
                  ->on('tbl_equipment_code')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
            
            $table->integer('qty_install');

            $table->integer('tbl_manufacturer_code_id')->unsigned();
            $table->foreign('tbl_manufacturer_code_id')->references('id')
                  ->on('tbl_manufacturer_code')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('part_master_id','tbl_equipment_code_id', 'tbl_manufacturer_code_id'), 'part_equipment_code_pmi_teci_tmci');

            $table->string('doc_ref');
            $table->string('dwg_ref');

            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                  ->on('users')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
                  
            $table->integer('last_updated_by')->unsigned();
            $table->foreign('last_updated_by')->references('id')
                  ->on('users')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
                  
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
        Schema::dropIfExists('part_equipment_code');
    }
}
