<?php

use Illuminate\Database\Seeder;

class TblLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\TblLocation::insert([
            [
            	'location' => 'LOCATION 1 PETROKIMIA',
                'description' => 'LOCATION 1 PUPUK PETROKIMIA GRESIK',
            	'tbl_plant_id' => 1,            	
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'location' => 'LOCATION 2 PETROKIMIA',            	
            	'description' => 'LOCATION 2 PUPUK PETROKIMIA GRESIK',
                'tbl_plant_id' => 2,
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'location' => 'LOCATION 1 ISKANDAR MUDA',            	
            	'description' => 'LOCATION 1 PUPUK ISKANDAR MUDA ACEH',
                'tbl_plant_id' => 3,
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'location' => 'LOCATION 2 ISKANDAR MUDA',            	
            	'description' => 'LOCATION 2 PUPUK ISKANDAR MUDA ACEH',
                'tbl_plant_id' => 4,
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
