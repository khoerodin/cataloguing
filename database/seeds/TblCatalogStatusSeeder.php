<?php

use Illuminate\Database\Seeder;

class TblCatalogStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\TblCatalogStatus::insert([
	        [
	        	'status' => 'RAW',
	        	'description' => '',
	        	'created_by' => 2,
	        	'last_updated_by' => 1,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'status' => 'CAT',
	          'description' => '',
	          'created_by' => 2,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'status' => 'QA',
	          'description' => '',
	          'created_by' => 2,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'status' => 'PRINTED LOCK',
	          'description' => '',
	          'created_by' => 2,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
