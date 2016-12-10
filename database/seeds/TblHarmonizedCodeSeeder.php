<?php

use Illuminate\Database\Seeder;

class TblHarmonizedCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\TblHarmonizedCode::insert([
	        [
	        	'code' => '03GM',
	        	'description' => '',
	        	'created_by' => 3,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'code' => '05490',
	          'description' => '',
	          'created_by' => 3,
	        	'last_updated_by' => 4,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'code' => '0B2M',
	          'description' => '',
	          'created_by' => 3,
	        	'last_updated_by' => 4,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'code' => '0F2M',
	          'description' => '',
	          'created_by' => 3,
	        	'last_updated_by' => 4,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
