<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartSourceDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_source_description', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('inc');
            $table->string('item_name');
            $table->string('group_class');
            $table->string('uom');
            $table->text('source');

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
        Schema::drop('part_source_description');
    }
}
