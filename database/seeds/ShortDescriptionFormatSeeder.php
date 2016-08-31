<?php

use Illuminate\Database\Seeder;

class ShortDescriptionFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\ShortDescriptionFormat::insert([
            [
            	'link_inc_characteristic_id' => 1,
            	'separator' => ';',
                'sequence' => 1,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 2,
            	'separator' => ';',
                'sequence' => 2,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 3,
            	'separator' => 'X',
                'sequence' => 3,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 4,
            	'separator' => 'X',
                'sequence' => 4,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 5,
            	'separator' => ';',
                'sequence' => 5,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 6,
            	'separator' => ';',
                'sequence' => 6,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 8,
            	'separator' => ';',
                'sequence' => 7,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 7,
            	'separator' => ';',
                'sequence' => 8,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 11,
            	'separator' => ';',
                'sequence' => 9,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 13,
            	'separator' => ';',
                'sequence' => 10,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 19,
            	'separator' => ';',
                'sequence' => 11,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 15,
            	'separator' => ';',
                'sequence' => 12,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'link_inc_characteristic_id' => 14,
            	'separator' => ';',
                'sequence' => 13,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
