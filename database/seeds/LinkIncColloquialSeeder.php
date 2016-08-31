<?php

use Illuminate\Database\Seeder;

class LinkIncColloquialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\LinkIncColloquial::insert([
          [
          	'tbl_inc_id' => 1,
          	'tbl_colloquial_id' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_inc_id' => 2,
          	'tbl_colloquial_id' => 2,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_inc_id' => 3,
          	'tbl_colloquial_id' => 3,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_inc_id' => 4,
          	'tbl_colloquial_id' => 4,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_inc_id' => 3,
          	'tbl_colloquial_id' => 5,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
      ]);
    }
}
