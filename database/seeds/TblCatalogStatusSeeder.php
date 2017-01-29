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
	        	'sequence' => '1',
	        	'created_by' => 2,
	        	'last_updated_by' => 1,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'status' => 'CAT',
	          'description' => '',
	          'sequence' => '2',
	          'created_by' => 2,
	          'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'status' => 'QA',
	          'description' => '',
	          'sequence' => '3',
	          'created_by' => 2,
	          'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'status' => 'LOCKED',
	          'description' => '',
	          'sequence' => '4',
	          'created_by' => 2,
	          'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
