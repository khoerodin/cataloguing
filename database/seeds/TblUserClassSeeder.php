<?php

use Illuminate\Database\Seeder;

class TblUserClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now = Carbon\Carbon::now();
	      App\Models\TblUserClass::insert([
	        [
	        	'class' => 'CATALYST/PALL RING',
	        	'description' => '',
	        	'created_by' => 3,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'class' => 'COMPRESSOR & PUMP',
	          'description' => '',
	          'created_by' => 3,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'class' => 'DIRECT ISSUE',
	          'description' => '',
	          'created_by' => 3,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'class' => 'OBSOLETE SPARE STOCK',
	          'description' => '',
	          'created_by' => 3,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
