<?php

use Illuminate\Database\Seeder;

class TblBinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\TblBin::insert([
            [
            	'bin' => 'BIN 1 PETRO SHELF 1',
            	'description' => 'BIN 1 PUPUK PETROKIMIA GRESIK',
                'tbl_shelf_id' => 1,
            	'created_by' => 1,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'bin' => 'BIN 2 PETRO SHELF 2',
            	'description' => 'BIN 2 PUPUK PETROKIMIA GRESIK',
                'tbl_shelf_id' => 2,
            	'created_by' => 1,
                'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'bin' => 'BIN 1 ISKANDAR SHELF 1',
            	'description' => 'BIN 1 PUPUK ISKANDAR MUDA',
                'tbl_shelf_id' => 3,
            	'created_by' => 1,
                'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'bin' => 'BIN 2 ISKANDAR SHELF 2',
            	'description' => 'BIN 2 PUPUK ISKANDAR MUDA',
                'tbl_shelf_id' => 4,
            	'created_by' => 1,
                'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
