<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblColloquialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_colloquial', function (Blueprint $table) {
            $table->increments('id');

            $table->string('colloquial');

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
        Schema::dropIfExists('tbl_colloquial');
    }
}
