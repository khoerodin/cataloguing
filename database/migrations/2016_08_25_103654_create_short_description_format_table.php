<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortDescriptionFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_description_format', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('link_inc_characteristic_id')->unsigned()->unique();
            $table->foreign('link_inc_characteristic_id', 'short_description_format_lici')->references('id')
                  ->on('link_inc_characteristic')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

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
        Schema::drop('short_description_format');
    }
}
