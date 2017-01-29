<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('catalog_no', 30)->nullable();
            $table->string('holding_no')->nullable();
            $table->bigInteger('inc_id')->nullable();
            $table->bigInteger('colloquial_id')->nullable();
            $table->bigInteger('group_class_id')->nullable();
            $table->bigInteger('catalog_status_id')->nullable();
            $table->enum('catalog_type', ['gen','oem'])->nullable();
            $table->bigInteger('item_type_id')->nullable();
            $table->bigInteger('man_code_id')->nullable();
            $table->string('part_number')->nullable();
            $table->bigInteger('equipment_code_id')->nullable();
            $table->bigInteger('holding_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('plant_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('shelf_id')->nullable();
            $table->bigInteger('bin_id')->nullable();
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
        Schema::dropIfExists('tbl_search');
    }
}
