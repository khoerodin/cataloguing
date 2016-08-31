<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCharacteristicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_characteristic', function (Blueprint $table) {
            $table->increments('id');

            $table->string('characteristic', 30)->unique();
            $table->string('label', 30)->unique();
            $table->enum('position', ['before','after']);
            $table->boolean('space');
            $table->enum('type', ['gen','oem']);

            //============================================================================
            //fitur custom characteristic sesuai permintaan holding, ada di tabel sendiri
            //============================================================================
            
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
        Schema::drop('tbl_characteristic');
    }
}
