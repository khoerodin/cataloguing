<?php

use Illuminate\Database\Seeder;

class PartMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	$now 	    	= Carbon\Carbon::now();

	      App\Models\PartMaster::insert([
	        [
	        	'catalog_no' => '100023',
	        	'tbl_holding_id' => 1,
	        	'holding_no' => 'HOLD1N6A',

	        	'reference_no' => 'HOLD1N6A',
	        	'link_inc_group_class_id' => 3,
	        	
	        	'unit_issue' => 1,
	        	'unit_purchase' => 2,

	        	'conversion' => '12',	        
	        	'tbl_catalog_status_id' => 1,	        		
	        	'tbl_user_class_id' =>1,
	        	
	        	'catalog_type' => 'gen',
	        	'tbl_item_type_id' => 1,
	        	'tbl_harmonized_code_id' => 1,
	        	'tbl_hazard_class_id' => 1,
	        	'weight_value' => '123.5',

	        	'tbl_weight_unit_id' => 1,
	        	'tbl_stock_type_id' => 1,
	        	'average_unit_price' => '30.5',

	        	'memo' => 'TEST MEMO',
	        	'edit_mode' => 1,
	        	'edit_mode_by' => 2,

	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'catalog_no' => '100024',
	        	'tbl_holding_id' => 1,
	        	'holding_no' => 'HOLD1N6B',

	        	'reference_no' => 'HOLD1N6B',
	        	'link_inc_group_class_id' => 4,

	        	'unit_issue' => 1,
	        	'unit_purchase' => 2,

	        	'conversion' => '13',
	        	'tbl_catalog_status_id' => 1,
	        	'tbl_user_class_id' =>1,

	        	'catalog_type' => 'gen',
	        	'tbl_item_type_id' => 1,
	        	'tbl_harmonized_code_id' => 1,
	        	'tbl_hazard_class_id' => 1,
	        	'weight_value' => '125',

	        	'tbl_weight_unit_id' => 1,
	        	'tbl_stock_type_id' => 1,
	        	'average_unit_price' => '34.5',

	        	'memo' => 'TEST MEMO',
	        	'edit_mode' => 1,
	        	'edit_mode_by' => 2,

	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'catalog_no' => '100025',
	        	'tbl_holding_id' => 1,
	        	'holding_no' => 'HOLD1N6C',

	        	'reference_no' => 'HOLD1N6C',
	        	'link_inc_group_class_id' => 5,
	        	
	        	'unit_issue' => 1,
	        	'unit_purchase' => 2,

	        	'conversion' => '17',
	        	'tbl_catalog_status_id' => 1,
	        	'tbl_user_class_id' =>1,

	        	'catalog_type' => 'gen',
	        	'tbl_item_type_id' => 1,
	        	'tbl_harmonized_code_id' => 1,
	        	'tbl_hazard_class_id' => 1,
	        	'weight_value' => '128',

	        	'tbl_weight_unit_id' => 1,
	        	'tbl_stock_type_id' => 1,
	        	'average_unit_price' => '30.5',

	        	'memo' => 'TEST MEMO',
	        	'edit_mode' => 1,
	        	'edit_mode_by' => 3,

	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'catalog_no' => '100026',
	        	'tbl_holding_id' => 1,
	        	'holding_no' => 'HOLD1N6D',

	        	'reference_no' => 'HOLD1N6D',
	        	'link_inc_group_class_id' => 3,
	        	
	        	'unit_issue' => 1,
	        	'unit_purchase' => 2,

	        	'conversion' => '17',
	        	'tbl_catalog_status_id' => 1,
	        	'tbl_user_class_id' =>1,

	        	'catalog_type' => 'gen',
	        	'tbl_item_type_id' => 1,
	        	'tbl_harmonized_code_id' => 1,
	        	'tbl_hazard_class_id' => 1,
	        	'weight_value' => '128',

	        	'tbl_weight_unit_id' => 1,
	        	'tbl_stock_type_id' => 1,
	        	'average_unit_price' => '30.5',

	        	'memo' => 'TEST MEMO',
	        	'edit_mode' => 1,
	        	'edit_mode_by' => 3,

	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'catalog_no' => '100027',
	        	'tbl_holding_id' => 1,
	        	'holding_no' => 'HOLD1N6E',

	        	'reference_no' => 'HOLD1N6E',
	        	'link_inc_group_class_id' => 3,
	        	
	        	'unit_issue' => 1,
	        	'unit_purchase' => 2,

	        	'conversion' => '17',
	        	'tbl_catalog_status_id' => 1,
	        	'tbl_user_class_id' =>1,

	        	'catalog_type' => 'gen',
	        	'tbl_item_type_id' => 1,
	        	'tbl_harmonized_code_id' => 1,
	        	'tbl_hazard_class_id' => 1,
	        	'weight_value' => '128',

	        	'tbl_weight_unit_id' => 1,
	        	'tbl_stock_type_id' => 1,
	        	'average_unit_price' => '30.5',

	        	'memo' => 'TEST MEMO',
	        	'edit_mode' => 1,
	        	'edit_mode_by' => 3,

	        	'created_by' => 1,
	        	'last_updated_by' => 2,
	        	'created_at' => $now,
	        	'updated_at' => $now
	        ],
	      ]);
    }
}