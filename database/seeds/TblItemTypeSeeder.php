<?php

use Illuminate\Database\Seeder;

class TblItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $now = Carbon\Carbon::now();
	    App\Models\TblItemType::insert([
	        [
	        	'type' => 'ELECTRICAL & ELECTRONIC',
	        	'description' => 'ELECTRICAL & ELECTRONIC',
	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	          'type' => 'VALVE COMPLETE AND SPARE PARTS',
	          'description' => 'VALVE COMPLETE AND SPARE PARTS',
	          'created_by' => 1,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'type' => 'AUTOMOTIVE MOBILE',
	          'description' => 'AUTOMOTIVE MOBILE',
	          'created_by' => 1,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'type' => 'COMPRESSOR & PUMP',
	          'description' => 'COMPRESSOR & PUMP',
	          'created_by' => 1,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	        [
	          'type' => 'FURNACE,STEAM PLANT,HEAT EXC',
	          'description' => 'FURNACE,STEAM PLANT,HEAT EXC',
	          'created_by' => 1,
	        	'last_updated_by' => 2,
	          'created_at' => $now,
	          'updated_at' => $now
	        ],
	      ]);
    }
}
