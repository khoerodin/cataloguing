<?php

use Illuminate\Database\Seeder;

class CompanyShortDescriptionFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $now = Carbon\Carbon::now();
      	App\Models\CompanyShortDescriptionFormat::insert([
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 1,
          	'separator' => ';',
          	'sequence' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 2,
          	'separator' => ';',
          	'sequence' => 2,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 3,
          	'separator' => ';',
          	'sequence' => 3,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 4,
          	'separator' => ';',
          	'sequence' => 4,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 5,
          	'separator' => ';',
          	'sequence' => 5,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 6,
          	'separator' => ';',
          	'sequence' => 6,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 7,
          	'separator' => ';',
          	'sequence' => 7,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 8,
          	'separator' => ';',
          	'sequence' => 8,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 9,
          	'separator' => ';',
          	'sequence' => 9,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'tbl_company_id' => 1,
          	'short_description_format_id' => 10,
          	'separator' => ';',
          	'sequence' => 10,
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
        ]);
    }
}
