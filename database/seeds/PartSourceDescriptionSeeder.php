<?php

use Illuminate\Database\Seeder;

class PartSourceDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
      	App\Models\PartSourceDescription::insert([
          [          	
          	'part_master_id' => 1,
            'inc' => 'A123',
            'item_name' => 'LOREM IPSUM',
            'group_class' => '',
            'unit_issue' => '',
            'short' => '-',
            'source' => 'SOURCE 100023 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [ 
            'part_master_id' => 2,
            'inc' => '',
            'item_name' => '',
            'group_class' => '7834',
            'unit_issue' => '',
            'short' => '-',
          	'source' => 'SOURCE 100024 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'part_master_id' => 3,
            'inc' => '',
            'item_name' => 'HIS NAME',
            'group_class' => '',
            'unit_issue' => '',
            'short' => '-',
            'source' => 'SOURCE 100025 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'part_master_id' => 4,
            'inc' => '',
            'item_name' => '',
            'group_class' => '',
            'unit_issue' => '',
            'short' => '-',
            'source' => 'SOURCE 100026 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'part_master_id' => 5,
            'inc' => '7875S',
            'item_name' => 'NAME OKE',
            'group_class' => '2383',
            'unit_issue' => 'EACH',
            'short' => '-',
            'source' => 'SOURCE 100027 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
          	'created_by' => 2,
          	'last_updated_by' => 1,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
      ]);
    }
}