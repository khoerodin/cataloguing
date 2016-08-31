<?php

use Illuminate\Database\Seeder;

class PartBinLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\PartBinLocation::insert([
            [
            	'part_master_id' => 1,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 1,
                'tbl_location_id' => 1,
                'tbl_shelf_id' => 1,
                'tbl_bin_id' => 1,
                'stock_on_hand' => 12,
            	'tbl_unit_of_measurement_id' => 1,
            	'created_by' => 3,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
                'part_master_id' => 1,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 2,
                'tbl_location_id' => 2,
                'tbl_shelf_id' => 2,
                'tbl_bin_id' => 2,
                'stock_on_hand' => 11,
                'tbl_unit_of_measurement_id' => 2,
                'created_by' => 3,
                'last_updated_by' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'part_master_id' => 2,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 3,
                'tbl_location_id' => 3,
                'tbl_shelf_id' => 3,
                'tbl_bin_id' => 3,
                'stock_on_hand' => 10,
                'tbl_unit_of_measurement_id' => 1,
                'created_by' => 3,
                'last_updated_by' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'part_master_id' => 2,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 4,
                'tbl_location_id' => 4,
                'tbl_shelf_id' => 4,
                'tbl_bin_id' => 4,
                'stock_on_hand' => 9,
                'tbl_unit_of_measurement_id' => 2,
                'created_by' => 3,
                'last_updated_by' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'part_master_id' => 3,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 4,
                'tbl_location_id' => 4,
                'tbl_shelf_id' => 4,
                'tbl_bin_id' => 4,
                'stock_on_hand' => 9,
                'tbl_unit_of_measurement_id' => 2,
                'created_by' => 3,
                'last_updated_by' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
            /*[
                'part_master_id' => 4,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 4,
                'tbl_location_id' => 4,
                'tbl_shelf_id' => 4,
                'tbl_bin_id' => 4,
                'stock_on_hand' => 9,
                'tbl_unit_of_measurement_id' => 2,
                'created_by' => 3,
                'last_updated_by' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],*/
            [
                'part_master_id' => 5,
                'tbl_company_id' => 1,
                'tbl_plant_id' => 4,
                'tbl_location_id' => 4,
                'tbl_shelf_id' => 4,
                'tbl_bin_id' => 4,
                'stock_on_hand' => 9,
                'tbl_unit_of_measurement_id' => 2,
                'created_by' => 3,
                'last_updated_by' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
