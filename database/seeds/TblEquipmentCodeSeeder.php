<?php

use Illuminate\Database\Seeder;

class TblEquipmentCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now = Carbon\Carbon::now();
	      App\Models\TblEquipmentCode::insert([
	        [
	        	'equipment_code' => '0107GA402A',
	        	'equipment_name' => 'PUMP, HP ABSORBENT',
	        	'tbl_plant_id' => 1,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'equipment_code' => '0107JC301',
	        	'equipment_name' => 'ELEVATOR FOR OPERATOR',
	        	'tbl_plant_id' => 1,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'equipment_code' => '0107MM2381',
	        	'equipment_name' => 'MOTOR, PRILLED UREA CONVEYOR',
	        	'tbl_plant_id' => 1,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'equipment_code' => '0108C1101',
	        	'equipment_name' => 'COMPRESSOR  REFRIGERANT',
	        	'tbl_plant_id' => 1,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'equipment_code' => '01E1203',
	        	'equipment_name' => 'HEATER  WATER FOR SODA SOLUTION',
	        	'tbl_plant_id' => 1,
	        	'created_by' => 2,
	        	'last_updated_by' => 4,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
