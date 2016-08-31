<?php

use Illuminate\Database\Seeder;

class TblHoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {		
        $now = Carbon\Carbon::now();
        App\Models\TblHolding::insert([
            [
            	'holding' => 'PUPUK INDONESIA HOLDING COMPANY',
            	'description' => 'PUPUK INDONESIA HOLDING COMPANY',
            	'created_by' => 4,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'holding' => 'SEMEN INDONESIA HOLDING COMPANY',
            	'description' => 'SEMEN INDONESIA HOLDING COMPANY',
            	'created_by' => 4,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'holding' => 'KHOIRUDDIN CORPORATION',
            	'description' => 'KHOIRUDDIN CORPORATION',
            	'created_by' => 4,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
