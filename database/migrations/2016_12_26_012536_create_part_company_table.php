<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_company', function (Blueprint $table) {
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

            $table->unique(array('part_master_id', 'tbl_company_id'));

            $table->integer('tbl_catalog_status_id')->unsigned();
            $table->foreign('tbl_catalog_status_id')->references('id')
                  ->on('tbl_catalog_status')
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
        Schema::dropIfExists('part_company');
    }
}
