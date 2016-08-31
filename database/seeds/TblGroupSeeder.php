<?php

use Illuminate\Database\Seeder;

class TblGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\TblGroup::insert([
            [
            	'group' => '11',
            	'name' => 'NUCLEAR ORDNANCE',
            	'created_by' => 2,
            	'last_updated_by' => 3,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'group' => '13',
            	'name' => 'AMMUNITION AND EXPLOSIVES',
            	'created_by' => 2,
            	'last_updated_by' => 3,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'group' => '30',
            	'name' => 'MECHANICAL POWER TRANSMISSION EQUIPMENT',
            	'created_by' => 2,
            	'last_updated_by' => 3,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'group' => '31',
            	'name' => 'BEARINGS',
            	'created_by' => 2,
            	'last_updated_by' => 3,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'group' => '43',
            	'name' => 'PUMPS AND COMPRESSORS',
            	'created_by' => 2,
            	'last_updated_by' => 3,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
