<?php

use Illuminate\Database\Seeder;

class PartColloquialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\PartColloquial::insert([
            [
            	'tbl_colloquial_id' => 1,
                'part_master_id' => 1,
            	'created_by' => 2,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'tbl_colloquial_id' => 2,
                'part_master_id' => 1,
            	'created_by' => 2,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'tbl_colloquial_id' => 3,
                'part_master_id' => 1,
            	'created_by' => 2,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'tbl_colloquial_id' => 4,
                'part_master_id' => 2,
            	'created_by' => 2,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'tbl_colloquial_id' => 5,
                'part_master_id' => 3,
            	'created_by' => 2,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'tbl_colloquial_id' => 5,
                'part_master_id' => 3,
            	'created_by' => 2,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
