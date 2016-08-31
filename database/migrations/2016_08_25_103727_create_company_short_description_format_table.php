<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyShortDescriptionFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_short_description_format', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_company_id')->unsigned();
            $table->foreign('tbl_company_id')->references('id')
                  ->on('tbl_company')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('short_description_format_id')->unsigned();
            $table->foreign('short_description_format_id','company_shor  
  t_description_format_sdfi_foreign')->references('id')
                  ->on('short_description_format')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('tbl_company_id', 'short_description_format_id'),'company_short_description_format_tci_licvi_unique');

            $table->string('separator', 10)->nullable();

            $table->tinyInteger('sequence')->nullable();

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
        Schema::drop('company_short_description_format');
    }
}
