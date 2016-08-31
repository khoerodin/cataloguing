<?php

use Illuminate\Database\Seeder;

class TblUnitOfMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\TblUnitOfMeasurement::insert([
            [
            	'unit4' => 'ASY',
            	'unit3' => 'ASS',
            	'unit2' => 'AS',
            	'description' => 'ASSEMBLY',
            	'eng_definition' => 'A COLLECTION OF PARTS ASSEMBLED TO FORM A COMPLETE UNIT, CONSTITUTING A SINGLE ITEM OF SUPPLY E.G. HOSE ASSEMBLY.',
            	'ind_definition' => '',
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
              'unit4' => 'BRU',
            	'unit3' => 'BRL',
            	'unit2' => 'BU',
            	'description' => 'BARREL (US)',
            	'eng_definition' => 'A COLLECTION OF PARTS ASSEMBLED TO FORM A COMPLETE UNIT, CONSTITUTING A SINGLE ITEM OF SUPPLY E.G. HOSE ASSEMBLY.',
            	'ind_definition' => '',
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
        ]);
    }
}
