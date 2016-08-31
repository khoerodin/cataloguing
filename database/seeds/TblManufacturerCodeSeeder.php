<?php

use Illuminate\Database\Seeder;

class TblManufacturerCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now 	    = Carbon\Carbon::now();
	      App\Models\TblManufacturerCode::insert([
	        [
	        	'manufacturer_code' => 'CCI',
	        	'manufacturer_name' => 'CCI (IMI SEVERE SERVICE COMPANY)',
	        	'address' => '',
	        	'created_by' => 1,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'manufacturer_code' => 'DELTA-V',
	        	'manufacturer_name' => 'DELTA-V SYSTEMS-EMERSON GROUP',
	        	'address' => '',
	        	'created_by' => 1,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'manufacturer_code' => 'FAIRBANK',
	        	'manufacturer_name' => 'FAIRBANK-MORSE COMPANY',
	        	'address' => '',
	        	'created_by' => 1,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'manufacturer_code' => 'GESENSING',
	        	'manufacturer_name' => 'GE SENSING & INSPECTION TECHNOLOGIES',
	        	'address' => '',
	        	'created_by' => 1,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
