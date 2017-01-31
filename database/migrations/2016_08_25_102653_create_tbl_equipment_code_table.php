<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEquipmentCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_equipment_code', function (Blueprint $table) {
            $table->increments('id');

            $table->string('equipment_code', 50);
            $table->string('equipment_name');
            $table->string('document_ref');

            $table->integer('tbl_company_id')->unsigned();
            $table->foreign('tbl_company_id')->references('id')
                  ->on('tbl_company')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_plant_id')->unsigned();
            $table->foreign('tbl_plant_id')->references('id')
                  ->on('tbl_plant')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('equipment_code', 'tbl_company_id'));

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
        Schema::dropIfExists('tbl_equipment_code');
    }
}
