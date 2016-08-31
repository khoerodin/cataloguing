<?php

use Illuminate\Database\Seeder;

class TblWeightUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now 	= Carbon\Carbon::now();
	      App\Models\TblWeightUnit::insert([
	        [
	        	'unit' => 'GR',
	        	'description' => 'GRAM',
	        	'created_by' => 1,
	        	'last_updated_by' => 1,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'unit' => 'KG',
	          'description' => 'KILOGRAM',
	          'created_by' => 1,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'unit' => 'LB',
	          'description' => 'POUND',
	          'created_by' => 1,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'unit' => 'TON',
	          'description' => 'METRIC TON',
	          'created_by' => 1,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'unit' => 'OZ',
	          'description' => 'OUNCE',
	          'created_by' => 1,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
