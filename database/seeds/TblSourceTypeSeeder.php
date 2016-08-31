<?php

use Illuminate\Database\Seeder;

class TblSourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now 	    = Carbon\Carbon::now();
	      App\Models\TblSourceType::insert([
	        [
	        	'type' => 'DOC',
	        	'description' => 'DOCUMENT NUMBER',
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'DWG',
	          'description' => 'DRAWING NUMBER',
	          'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'MPN',
	          'description' => 'MANUFACTURER PART NUMBER',
	          'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
