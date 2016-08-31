<?php

use Illuminate\Database\Seeder;

class TblColloquialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $now = Carbon\Carbon::now();
      App\Models\TblColloquial::insert([
          [
          	'colloquial' => 'SATU',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'colloquial' => 'DUA',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'colloquial' => 'TIGA',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'colloquial' => 'EMPAT',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'colloquial' => 'LIMA',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
      ]);
    }
}
