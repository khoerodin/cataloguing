<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblIncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inc', function (Blueprint $table) {
            $table->increments('id');

            $table->string('inc', 5)->unique();
            $table->string('item_name')->unique();

            //=============================================
            //Noun - Modifier dibuat di view/di coding aja
            //=============================================

            $table->string('short_name')->unique(); //buat short description
            $table->string('sap_code', 30)->unique();
            $table->string('sap_char_id', 18)->unique();
            $table->text('eng_definition')->nullable();
            $table->text('ind_definition')->nullable();

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
        Schema::dropIfExists('tbl_inc');
    }
}
