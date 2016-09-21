<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkIncCharacteristicValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_inc_characteristic_value', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('link_inc_characteristic_id')->unsigned();
            $table->foreign('link_inc_characteristic_id')->references('id')
                  ->on('link_inc_characteristic')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('value', 30);

            $table->unique(array('link_inc_characteristic_id', 'value'), 'link_inc_characteristic_value_lici_v_unique');

            $table->string('abbrev', 30)->nullable('');
            $table->boolean('approved')->default(0);

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
        Schema::drop('link_inc_characteristic_value');
    }
}
