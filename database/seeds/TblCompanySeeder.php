<?php

use Illuminate\Database\Seeder;

class TblCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\TblCompany::insert([
            [
            	'company' => 'PT. PETROKIMIA GRESIK',
                'description' => 'PT. PETROKIMIA GRESIK',
            	'tbl_holding_id' => 1,
                'uom_type' => '3',
            	'created_by' => 2,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'company' => 'PT. PUPUK KALTIM',            	
            	'description' => 'PT. PUPUK KALTIM',
                'tbl_holding_id' => 1,
                'uom_type' => '3',
            	'created_by' => 2,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'company' => 'PT. PUPUK KUJANG',            	
            	'description' => 'PT. PUPUK KUJANG',
                'tbl_holding_id' => 1,
                'uom_type' => '3',
            	'created_by' => 2,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'company' => 'PT. PUPUK ISKANDAR MUDA',            	
            	'description' => 'PT. PUPUK ISKANDAR MUDA',
                'tbl_holding_id' => 1,
                'uom_type' => '3',
            	'created_by' => 2,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
                'company' => 'KHOIRUDDIN COMPANY',             
                'description' => 'KHOIRUDDIN COMPANY',
                'tbl_holding_id' => 3,
                'uom_type' => '3',
                'created_by' => 2,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
