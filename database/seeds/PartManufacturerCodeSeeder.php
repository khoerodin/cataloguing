<?php

use Illuminate\Database\Seeder;

class PartManufacturerCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\PartManufacturerCode::insert([
	        [
	        	'part_master_id' => 1,
	        	'tbl_manufacturer_code_id' => 1,
	        	'tbl_source_type_id' => 1,
	        	'manufacturer_ref' => 'SSNP-GEN-MEC-VDR-002/10',
	        	'tbl_part_manufacturer_code_type_id' => 4,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 1,
	        	'tbl_manufacturer_code_id' => 2,
	        	'tbl_source_type_id' => 2,
	        	'manufacturer_ref' => 'DW1015-01-001-POS N3',
	        	'tbl_part_manufacturer_code_type_id' => 4,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 1,
	        	'tbl_manufacturer_code_id' => 3,
	        	'tbl_source_type_id' => 3,
	        	'manufacturer_ref' => '3836-R-SF-316-316-10IN-300LB-4.5T',
	        	'tbl_part_manufacturer_code_type_id' => 4,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
