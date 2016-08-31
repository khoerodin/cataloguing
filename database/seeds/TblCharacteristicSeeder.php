<?php

use Illuminate\Database\Seeder;

class TblCharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now = Carbon\Carbon::now();
	      App\Models\TblCharacteristic::insert([
	        [
	        	'characteristic' => 'STYLE',
	        	'label' => 'STYLE',
	        	'position' => 'before',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'NUMBER OF ROW',
	        	'label' => 'NUMBER OF ROW',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'BORE DIAMETER',
	        	'label' => 'BORE DIA',
	        	'position' => 'before',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'OUTSIDE DIAMETER',
	        	'label' => 'OUTS DIA',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'WIDTH',
	        	'label' => 'WIDTH',
	        	'position' => 'before',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'SEAL DATA',
	        	'label' => 'SEAL DATA',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'MATERIAL',
	        	'label' => 'MATERIAL',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'CLEARANCE',
	        	'label' => 'CLEARANCE',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'TOLERANCE',
	        	'label' => 'TOLERANCE',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'SPECIFICATION/STD DATA',
	        	'label' => 'STD DATA',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'SPECIAL FEATURES',
	        	'label' => 'SPECIAL FEATURES',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'ADDITIONAL FEATURES',
	        	'label' => 'ADD FEATURES',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'TYPE OR USAGE',
	        	'label' => 'TYPE OR USAGE',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'EQUIPMENT NAME',
	        	'label' => 'EQ NAME',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'EQUIPMENT TYPE/MODEL',
	        	'label' => 'EQ TYPE/MODEL',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'SUB-ASSEMBLY',
	        	'label' => 'SUB-ASSEMBLY',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'EQUIPMENT SERIAL NUMBER',
	        	'label' => 'EQ SERIAL NUMBER',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'ADDITIONAL EQUIPMENT DATA',
	        	'label' => 'ADD EQ DATA',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'MANUFACTURER',
	        	'label' => 'MAN',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'ATTACHMENT DOCUMENT-1',
	        	'label' => 'ATTC DOC-1',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'ATTACHMENT DOCUMENT-2',
	        	'label' => 'ATTC DOC-2',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'DIMENSIONS',
	        	'label' => 'DIM',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'characteristic' => 'MATERIAL STANDARD',
	        	'label' => 'MATERIAL STD',
	        	'position' => 'after',
	        	'space' => '1',
	        	'type' => 'gen',
	        	'created_by' => 1,
	        	'last_updated_by' => 3,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}
