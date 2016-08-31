<?php

use Illuminate\Database\Seeder;

class TblStockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now = Carbon\Carbon::now();
	      App\Models\TblStockType::insert([
	        [
	        	'type' => 'CRITICAL',
	        	'description' => 'CRITICAL',
	        	'created_by' => 3,
	        	'last_updated_by' => 1,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'SLOW',
	          'description' => 'SLOW MOVING',
	          'created_by' => 3,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'type' => 'FAST',
	          'description' => 'FAST MOVING',
	          'created_by' => 3,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'type' => 'D',
	          'description' => 'DIRECT USE',
	          'created_by' => 3,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'type' => 'S',
	          'description' => 'STOCK',
	          'created_by' => 3,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
