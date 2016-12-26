<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartBinLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_bin_location', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('company_catalog_id')->unsigned();
            $table->foreign('company_catalog_id')->references('id')
                  ->on('company_catalog')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_plant_id')->unsigned()->nullable();
            $table->foreign('tbl_plant_id')->references('id')
                  ->on('tbl_plant')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_location_id')->unsigned()->nullable();
            $table->foreign('tbl_location_id')->references('id')
                  ->on('tbl_location')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION'); 

            $table->integer('tbl_shelf_id')->unsigned()->nullable();
            $table->foreign('tbl_shelf_id')->references('id')
                  ->on('tbl_shelf')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_bin_id')->unsigned()->nullable();
            $table->foreign('tbl_bin_id')->references('id')
                  ->on('tbl_bin')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
            
            $table->unique(array('company_catalog_id', 'tbl_plant_id', 'tbl_location_id', 'tbl_shelf_id', 'tbl_bin_id'), 'cc_tp_tl_ts_tb');

            $table->double('stock_on_hand', 15, 8)->default(0,0);
            
            $table->integer('tbl_unit_of_measurement_id')->unsigned()->nullable();
            $table->foreign('tbl_unit_of_measurement_id')->references('id')
                  ->on('tbl_unit_of_measurement')
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
        Schema::dropIfExists('part_bin_location');
    }
}
