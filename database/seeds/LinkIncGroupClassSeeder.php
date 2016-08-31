<?php

use Illuminate\Database\Seeder;

class LinkIncGroupClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now = Carbon\Carbon::now();
	      	App\Models\LinkIncGroupClass::insert([
	        [
	        	'tbl_inc_id' => 1,
	        	'tbl_group_class_id' => 1,
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'tbl_inc_id' => 1,
	        	'tbl_group_class_id' => 2,
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'tbl_inc_id' => 3,
	        	'tbl_group_class_id' => 3,
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'tbl_inc_id' => 4,
	        	'tbl_group_class_id' => 4,
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'tbl_inc_id' => 4,
	        	'tbl_group_class_id' => 5,
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'tbl_inc_id' => 4,
	        	'tbl_group_class_id' => 6,
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
