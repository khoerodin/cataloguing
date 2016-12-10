<?php

use Illuminate\Database\Seeder;

class TblPartManufacturerCodeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\TblPartManufacturerCodeType::insert([
	        [
	        	'type' => 'O',
	        	'description' => 'OBSOLETE',
	        	'created_by' => 2,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'R',
	        	'description' => 'RA USAH TAKON-TAKON',
	        	'created_by' => 2,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'S',
	        	'description' => 'SOPO KOWE?',
	        	'created_by' => 2,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'V',
	        	'description' => 'VALID',
	        	'created_by' => 2,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
