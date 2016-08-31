<?php

use Illuminate\Database\Seeder;

class PartCharacteristicValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\PartCharacteristicValue::insert([
            [
            	'part_master_id' => 1,
                'link_inc_characteristic_value_id' => 1,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 1,
                'link_inc_characteristic_value_id' => 3,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 1,
                'link_inc_characteristic_value_id' => 5,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 1,
                'link_inc_characteristic_value_id' => 7,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 1,
                'link_inc_characteristic_value_id' => 9,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 1,
                'link_inc_characteristic_value_id' => 13,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],

            // ================================================================

            [
            	'part_master_id' => 2,
                'link_inc_characteristic_value_id' => 39,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 2,
                'link_inc_characteristic_value_id' => 42,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 2,
                'link_inc_characteristic_value_id' => 44,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 2,
                'link_inc_characteristic_value_id' => 46,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 2,
                'link_inc_characteristic_value_id' => 47,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 2,
                'link_inc_characteristic_value_id' => 53,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],

            // =======================================================

            [
            	'part_master_id' => 3,
                'link_inc_characteristic_value_id' => 40,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 3,
                'link_inc_characteristic_value_id' => 42,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 3,
                'link_inc_characteristic_value_id' => 43,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 3,
                'link_inc_characteristic_value_id' => 46,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 3,
                'link_inc_characteristic_value_id' => 48,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'part_master_id' => 3,
                'link_inc_characteristic_value_id' => 54,
            	'short' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
