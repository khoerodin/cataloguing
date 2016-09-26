<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCharacteristicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_characteristic', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_company_id')->unsigned();
            $table->foreign('tbl_company_id')->references('id')
                  ->on('tbl_company')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('link_inc_characteristic_id')->unsigned();
            $table->foreign('link_inc_characteristic_id', 'company_characteristic_lici')->references('id')
                  ->on('link_inc_characteristic')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('custom_char_name')->default('');
            $table->tinyInteger('sequence')->default(0);

            $table->integer('tbl_po_style_id')->unsigned()->default(1);
            $table->foreign('tbl_po_style_id')->references('id')
                  ->on('tbl_po_style')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->tinyInteger('hidden')->default(0);

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
        Schema::drop('company_characteristic');
    }
}
