<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkIncColloquialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_inc_colloquial', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_inc_id')->unsigned();
            $table->foreign('tbl_inc_id')->references('id')
                  ->on('tbl_inc')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_colloquial_id')->unsigned();
            $table->foreign('tbl_colloquial_id')->references('id')
                  ->on('tbl_colloquial')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

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
        Schema::dropIfExists('link_inc_colloquial');
    }
}
