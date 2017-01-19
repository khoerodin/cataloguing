<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_bin', function (Blueprint $table) {
            $table->increments('id');

            $table->string('bin', 50);
            $table->string('description');

            $table->integer('tbl_shelf_id')->unsigned();
            $table->foreign('tbl_shelf_id')->references('id')
                  ->on('tbl_shelf')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');            

            $table->unique(array('bin', 'tbl_shelf_id'));

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
        Schema::dropIfExists('tbl_bin');
    }
}
