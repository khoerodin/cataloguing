<?php

use Illuminate\Database\Seeder;

class TblShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   		$now = Carbon\Carbon::now();
        App\Models\TblShelf::insert([
            [
            	'shelf' => 'SHELF 1 PETRO LOCATION 1',            	
            	'description' => 'SHELF 1 PUPUK PETROKIMIA GRESIK',
                'tbl_location_id' => 1,
            	'created_by' => 3,
            	'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'shelf' => 'SHELF 2 PETRO LOCATION 2',
            	'description' => 'SHELF 2 PUPUK PETROKIMIA GRESIK',
                'tbl_location_id' => 2,
            	'created_by' => 3,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'shelf' => 'SHELF 1 ISKANDAR MUDA LOCATION 1',
            	'description' => 'SHELF 1 PUPUK ISKANDAR MUDA ACEH',
                'tbl_location_id' => 3,
            	'created_by' => 3,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'shelf' => 'SHELF 2 ISKANDAR MUDA LOCATION 2',
            	'description' => 'SHELF 2 PUPUK ISKANDAR MUDA ACEH',
                'tbl_location_id' => 4,
            	'created_by' => 3,
                'last_updated_by' => 4,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
