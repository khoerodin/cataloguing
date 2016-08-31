<?php

use Illuminate\Database\Seeder;

class PartSourcePartNoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
      	App\Models\PartSourcePartNo::insert([
          [          	
          	'part_master_id' => 1,
            'manufacturer_code' => 'NEWLONG',
            'manufacturer' => 'NEWLONG INDUSTRIAL CO.',
            'manufacturer_ref' => '6876JHGA1',
            'ref_type' => 'DOC',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [           
            'part_master_id' => 1,
            'manufacturer_code' => 'BISMILLAH',
            'manufacturer' => 'BISMILLAH YA ALLAH',
            'manufacturer_ref' => '238479KJH52',
            'ref_type' => 'DWG',
            'created_by' => 2,
            'last_updated_by' => 1,
            'created_at' => $now,
            'updated_at' => $now
          ],
          [          	
          	'part_master_id' => 2,
            'manufacturer_code' => 'NEWLONG',
            'manufacturer' => 'NEWLONG INDUSTRIAL CO.',
            'manufacturer_ref' => '6876JHGA1',
            'ref_type' => 'DOC',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [          	
          	'part_master_id' => 3,
            'manufacturer_code' => 'NEWLONG',
            'manufacturer' => 'NEWLONG INDUSTRIAL CO.',
            'manufacturer_ref' => '6876JHGA1',
            'ref_type' => 'DOC',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [          	
          	'part_master_id' => 4,
            'manufacturer_code' => 'NEWLONG',
            'manufacturer' => 'NEWLONG INDUSTRIAL CO.',
            'manufacturer_ref' => '6876JHGA1',
            'ref_type' => 'DOC',
          	'created_by' => 2,
          	'last_updated_by' => 5,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [          	
          	'part_master_id' => 5,
            'manufacturer_code' => 'NEWLONG',
            'manufacturer' => 'NEWLONG INDUSTRIAL CO.',
            'manufacturer_ref' => '6876JHGA1',
            'ref_type' => 'DOC',
          	'created_by' => 2,
          	'last_updated_by' => 5,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
      	]);
    }
}
