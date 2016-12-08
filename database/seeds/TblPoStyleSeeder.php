<?php

use Illuminate\Database\Seeder;

class TblPoStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
      	App\Models\TblPoStyle::insert([
          [          	
          	'style_name' => 'default',
            'after_char_name' => '',
          	'devider' => ':',
          	'after_devider' => '',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
        ]);
    }
}
