<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkIncCharacteristicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_inc_characteristic', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_inc_id')->unsigned();
            $table->foreign('tbl_inc_id')->references('id')
                  ->on('tbl_inc')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_characteristic_id')->unsigned();
            $table->foreign('tbl_characteristic_id')->references('id')
                  ->on('tbl_characteristic')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('tbl_inc_id', 'tbl_characteristic_id'));

            $table->string('default_short_separator', 10)->default('');
            $table->integer('sequence');
            
            //=======================================================
            //SAP Char ID / INC untuk Char di SAP, dibikin view aja, atau gimana nanti lah
            //=======================================================
            
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
        Schema::dropIfExists('link_inc_characteristic');
    }
}
