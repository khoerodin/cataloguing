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

            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_company_id')->unsigned();
            $table->foreign('tbl_company_id')->references('id')
                  ->on('tbl_company')
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

            $table->double('stock_on_hand', 15, 8)->nullable();
            
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
        Schema::drop('part_bin_location');
    }
}
