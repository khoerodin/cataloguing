<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCheckShortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_check_short', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_company_id')->unsigned();
            $table->foreign('tbl_company_id')->references('id')
                  ->on('tbl_company')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('part_characteristic_value_id')->unsigned();
            $table->foreign('part_characteristic_value_id')->references('id')
                  ->on('part_characteristic_value')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('tbl_company_id', 'part_characteristic_value_id'),'company_check_short_tcd_pcvi_unique');

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
        Schema::dropIfExists('company_check_short');
    }
}
