<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPartManufacturerCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_manufacturer_code', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_manufacturer_code_id')->unsigned();
            $table->foreign('tbl_manufacturer_code_id')->references('id')
                  ->on('tbl_manufacturer_code')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_source_type_id')->unsigned();
            $table->foreign('tbl_source_type_id')->references('id')
                  ->on('tbl_source_type')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('manufacturer_ref', 100); //bisa part number, dwg/doc number dll

            $table->unique(array('part_master_id', 'tbl_manufacturer_code_id', 'tbl_source_type_id', 'manufacturer_ref'), 'part_manufacturer_code_tmci_tsti_mf');

            $table->integer('tbl_part_manufacturer_code_type_id')->unsigned();
            $table->foreign('tbl_part_manufacturer_code_type_id','pmc_tbl_part_manufacturer_code_type_id_foreign')->references('id')
                  ->on('tbl_part_manufacturer_code_type')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
                  
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
        Schema::dropIfExists('part_manufacturer_code');
    }
}
