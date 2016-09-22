<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyShortDescriptionFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_short_description_format', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('company_characteristic_id')->unsigned()->unique('csdf_ccid_unique');
            $table->foreign('company_characteristic_id','csdf_ccid_foreign')->references('id')
                  ->on('company_characteristic')
                  ->onUpdate('CASCADE')
                  ->onDelete('NO ACTION');

            $table->string('short_separator', 10)->nullable('');
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('hidden')->default(1);

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
        Schema::drop('company_short_description_format');
    }
}
