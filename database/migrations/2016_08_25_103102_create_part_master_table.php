<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_master', function (Blueprint $table) {
            $table->increments('id');

            $table->string('catalog_no', 30); //unik dalam satu holding aja          
            
            $table->integer('tbl_holding_id')->unsigned();
            $table->foreign('tbl_holding_id')->references('id')
                  ->on('tbl_holding')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('holding_no')->nullable(); //unik dalam satu holding aja
            $table->string('reference_no')->nullable(); //funtuk mengecek duplikasi holding_no

            $table->unique(array('catalog_no', 'tbl_holding_id'));
            $table->unique(array('holding_no', 'tbl_holding_id'));

            $table->integer('link_inc_group_class_id')->unsigned()->nullable();
            $table->foreign('link_inc_group_class_id')->references('id')
                  ->on('link_inc_group_class')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->enum('catalog_type', ['gen','oem']);

            $table->integer('unit_issue')->unsigned()->nullable();
            $table->foreign('unit_issue')->references('id')
                  ->on('tbl_unit_of_measurement')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('unit_purchase')->unsigned()->nullable();
            $table->foreign('unit_purchase')->references('id')
                  ->on('tbl_unit_of_measurement')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('conversion', 30)->default('');

            $table->integer('tbl_user_class_id')->unsigned()->nullable();
            $table->foreign('tbl_user_class_id')->references('id')
                  ->on('tbl_user_class')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');            

            $table->integer('tbl_item_type_id')->unsigned()->nullable();
            $table->foreign('tbl_item_type_id')->references('id')
                  ->on('tbl_item_type')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_harmonized_code_id')->unsigned()->nullable();
            $table->foreign('tbl_harmonized_code_id')->references('id')
                  ->on('tbl_harmonized_code')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_hazard_class_id')->unsigned()->nullable();
            $table->foreign('tbl_hazard_class_id')->references('id')
                  ->on('tbl_hazard_class')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->float('weight_value', 30)->default(0);

            $table->integer('tbl_weight_unit_id')->unsigned()->nullable();
            $table->foreign('tbl_weight_unit_id')->references('id')
                  ->on('tbl_weight_unit')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->integer('tbl_stock_type_id')->unsigned()->nullable();  
            $table->foreign('tbl_stock_type_id')->references('id')
                  ->on('tbl_stock_type')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');     

            $table->float('average_unit_price', 30)->default(0);

            $table->text('memo');
            $table->boolean('edit_mode')->default(0);

            $table->integer('edit_mode_by')->unsigned()->nullable();
            $table->foreign('edit_mode_by')->references('id')
                  ->on('users')
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
        Schema::dropIfExists('part_master');
    }
}
