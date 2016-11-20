<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblGroupClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_group_class', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tbl_group_id')->unsigned();
            $table->foreign('tbl_group_id')->references('id')
                  ->on('tbl_group')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('class')->length(2)->unsigned();

            $table->unique(array('tbl_group_id', 'class'));

            $table->string('name')->unique();     
              
            $table->text('eng_definition');
            $table->text('ind_definition');
                  
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

        DB::statement('ALTER TABLE tbl_group_class MODIFY class INTEGER(2) UNSIGNED ZEROFILL NOT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_group_class');
    }
}
