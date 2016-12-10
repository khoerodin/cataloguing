<?php

use Illuminate\Database\Seeder;

class TblHazardClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\TblHazardClass::insert([
	        [
	        	'class' => 'FS X NR',
	        	'description' => '',
	        	'created_by' => 2,
	        	'last_updated_by' => 1,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'class' => 'FS X NS',
	          'description' => '',
	          'created_by' => 2,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'class' => 'FS X NT',
	          'description' => '',
	          'created_by' => 2,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'class' => 'FT X NR',
	          'description' => '',
	          'created_by' => 2,
	        	'last_updated_by' => 1,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
