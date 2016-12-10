<?php

use Illuminate\Database\Seeder;

class PartEquipmentCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\PartEquipmentCode::insert([
	        [
	        	'part_master_id' => 1,
	        	'tbl_equipment_code_id' => 1,
	        	'qty_install' => 12,
	        	'tbl_manufacturer_code_id' => 1,
	        	'doc_ref' => 'SSNP-GEN-MEC-VDR-002/10',
	        	'dwg_ref' => 'SSNPGENMECVDR002/10',	        	
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 1,
	        	'tbl_equipment_code_id' => 2,
	        	'qty_install' => 34,
	        	'tbl_manufacturer_code_id' => 2,
	        	'doc_ref' => 'SSNP-GEN-MEC-VDR-002/2310',
	        	'dwg_ref' => 'SSNPGENMECVDEFDR002/10',	        	
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 2,
	        	'tbl_equipment_code_id' => 3,
	        	'qty_install' => 11,
	        	'tbl_manufacturer_code_id' => 3,
	        	'doc_ref' => 'SSNP-GEN-MEC-VDR-002/1420',
	        	'dwg_ref' => 'SSNPGENMECHUIVDR002/10',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 2,
	        	'tbl_equipment_code_id' => 4,
	        	'qty_install' => 34,
	        	'tbl_manufacturer_code_id' => 4,
	        	'doc_ref' => 'SSNP-GEN-MEC-VDR-002/1032',
	        	'dwg_ref' => 'SSNPGEDFNMECVDR002/10',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 3,
	        	'tbl_equipment_code_id' => 5,
	        	'qty_install' => 23,
	        	'tbl_manufacturer_code_id' => 1,
	        	'doc_ref' => 'SSNP-GEN-MEC-VDR-002/1780',
	        	'dwg_ref' => 'SSNPGERTNMECVDR002/10',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'part_master_id' => 3,
	        	'tbl_equipment_code_id' => 1,
	        	'qty_install' => 14,
	        	'tbl_manufacturer_code_id' => 2,
	        	'doc_ref' => 'SSNP-GEN-MEC-VDR-002/17',
	        	'dwg_ref' => 'SSNPGENMECVDRSD002/10',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
