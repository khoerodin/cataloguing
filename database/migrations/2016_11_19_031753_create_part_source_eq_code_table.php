<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartSourceEqCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_source_eq_code', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('equipment_code');
            $table->string('equipment_name');
            $table->string('qty_install');
            $table->string('manufacturer_code');
            $table->string('manufacturer_name');
            $table->string('doc_ref');
            $table->string('dwg_ref');
                  
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
        Schema::dropIfExists('part_source_eq_code');
    }
}
