<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tbl_part_attachment_id')->unsigned();
            $table->foreign('tbl_part_attachment_id')->references('id')
                  ->on('tbl_part_attachment')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');
            $table->integer('part_master_id')->unsigned();
            $table->foreign('part_master_id')->references('id')
                  ->on('part_master')
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
        Schema::dropIfExists('part_document');
    }
}
