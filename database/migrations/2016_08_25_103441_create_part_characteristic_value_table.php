<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartCharacteristicValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_characteristic_value', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('link_inc_characteristic_value_id')->unsigned();
            $table->foreign('link_inc_characteristic_value_id','pcv_link_inc_characteristic_value_id_foreign')->references('id')
                  ->on('link_inc_characteristic_value')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
            
            $table->unique(array('part_master_id', 'link_inc_characteristic_value_id'), 'part_characteristic_value_pmi_licvi_unique');

            $table->boolean('short')->default(0);

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
        Schema::drop('part_characteristic_value');
    }
}
