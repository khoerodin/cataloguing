<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_company', function (Blueprint $table) {
            $table->increments('id');

            $table->string('company', 50);
            $table->string('description');

            $table->integer('tbl_holding_id')->unsigned();
            $table->foreign('tbl_holding_id')->references('id')
                  ->on('tbl_holding')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->unique(array('company', 'tbl_holding_id'));
            $table->enum('uom_type', ['2','3', '4'])->default('3');  

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
        Schema::dropIfExists('tbl_company');
    }
}
