<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartMaster extends Model
{
    protected $table = 'part_master';
    protected $fillable = array(
    	'catalog_no', 'tbl_holding_id', 'holding_no',
    	'reference_no', 'link_inc_group_class_id',
    	// 'short_desc', 'long_desc', 
        'catalog_type', 'unit_issue', 
    	'unit_purchase', 'tbl_catalog_status_id',  'conversion',
    	'tbl_user_class_id','tbl_item_type_id','tbl_harmonized_code_id',
    	'tbl_hazard_class_id', 'weight_value','tbl_weight_unit_id',
    	'tbl_stock_type_id', 'average_unit_price', 'memo', 'edit_mode', 
        'edit_mode_by', 'created_by', 'last_updated_by'
    	);

    public function scopeSearchCatalogNo($query, $catalog_no)
    {
      if ($catalog_no) $query->where('catalog_no', '%'.$catalog_no.'%');
    }
}