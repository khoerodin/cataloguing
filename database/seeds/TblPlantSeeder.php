<?php

use Illuminate\Database\Seeder;

class TblPlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\TblPlant::insert([
            [
            	'plant' => 'PLANT 1 PETROKIMIA',
                'description' => 'PLANT 1 PUPUK PETROKIMIA GRESIK',
            	'tbl_company_id' => 1,            	
            	'created_by' => 3,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'plant' => 'PLANT 2 PETROKIMIA',            	
            	'description' => 'PLANT 2 PUPUK PETROKIMIA GRESIK',
                'tbl_company_id' => 1,
            	'created_by' => 3,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'plant' => 'PLANT 1 ISKANDAR MUDA',            	
            	'description' => 'PLANT 1 PUPUK ISKANDAR MUDA ACEH',
                'tbl_company_id' => 4,
            	'created_by' => 3,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'plant' => 'PLANT 2 ISKANDAR MUDA',            	
            	'description' => 'PLANT 2 PUPUK ISKANDAR MUDA ACEH',
                'tbl_company_id' => 4,
            	'created_by' => 3,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
