<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class PartMaster extends Model
{
    use \Conner\Tagging\Taggable;
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

    public function getPartMasterIdAttribute()
    {
        return Hashids::encode($this->attributes['part_master_id']);
    }

    public function getTblIncIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_inc_id']);
    }

    public function getLinkIncGroupClassIdAttribute()
    {
        return Hashids::encode($this->attributes['link_inc_group_class_id']);
    }

    public function getTblCompanyIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_company_id']);
    }

    public function getTblCatalogStatusIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_catalog_status_id']);
    }

    // SCOOP FOR SEARCH
    public function scopeSearchCatalogNo($query, $catalog_no)
    {
      if ($catalog_no != null) $query->where('catalog_no', $catalog_no);
    }

    public function scopeSearchHoldingNo($query, $holding_no)
    {
      if ($holding_no != null) $query->where('holding_no', $holding_no);
    }
    public function scopeSearchIncId($query, $inc_id)
    {
        if ($inc_id != null) $query->where('tbl_inc_id', $inc_id);
    }

    public function scopeSearchGroupClassId($query, $group_class_id)
    {
        if ($group_class_id != null) $query->where('tbl_group_class_id', $group_class_id);
    }

    public function scopeSearchCatalogType($query, $catalog_type)
    {
        if ($catalog_type != null) $query->where('catalog_type', $catalog_type);
    }

    public function scopeSearchCatalogStatusId($query, $catalog_status_id)
    {
        if ($catalog_status_id != null) $query->where('tbl_catalog_status_id', $catalog_status_id);
    }
    
    public function scopeSearchColloquialId($query, $colloquial_id)
    {
        if ($colloquial_id != null) 
            $query->join('part_colloquial', 'part_colloquial.part_master_id', '=', 'part_master.id')
            ->where('tbl_colloquial_id', $colloquial_id);
    }

    public function scopeSearchItemTypeId($query, $item_type_id)
    {
        if ($item_type_id != null) $query->where('tbl_item_type_id', $item_type_id);
    }

    public function scopeSearchManCodeId($query, $man_code_id)
    {
        if ($man_code_id != null) 
            $query->join('part_manufacturer_code as mancode', 'mancode.part_master_id', '=', 'part_master.id')
            ->where('tbl_manufacturer_code_id', $man_code_id);
    }

    public function scopeSearchPartNumber($query, $part_number)
    {
        if ($part_number != null) 
            $query->join('part_manufacturer_code as manref', 'manref.part_master_id', '=', 'part_master.id')
            ->where('manufacturer_ref', $part_number);
    }

    public function scopeSearchEquipmentCodeId($query, $equipment_code_id)
    {
        if ($equipment_code_id != null) 
            $query->join('part_equipment_code', 'part_equipment_code.part_master_id', '=', 'part_master.id')
            ->where('tbl_equipment_code_id', $equipment_code_id);
    }

    public function scopeSearchHoldingId($query, $holding_id)
    {
        if ($holding_id != null) $query->where('part_master.tbl_holding_id', $holding_id);
    }

    public function scopeSearchCompanyId($query, $company_id)
    {
        if ($company_id != null) $query->where('part_company.tbl_company_id', $company_id);
    }

    public function scopeSearchPlantId($query, $plant_id)
    {
        if ($plant_id != null) 
            $query->join('part_bin_location as plant', 'plant.part_master_id', '=', 'part_master.id')
            ->where('plant.tbl_plant_id', $plant_id);
    }

    public function scopeSearchLocationId($query, $location_id)
    {
        if ($location_id != null) 
            $query->join('part_bin_location as location', 'location.part_master_id', '=', 'part_master.id')
            ->where('location.tbl_location_id', $location_id);
    }

    public function scopeSearchShelfId($query, $shelf_id)
    {
        if ($shelf_id != null) 
            $query->join('part_bin_location as shelf', 'shelf.part_master_id', '=', 'part_master.id')
            ->where('shelf.tbl_shelf_id', $shelf_id);
    }

    public function scopeSearchBinId($query, $bin_id)
    {
        if ($bin_id != null) 
            $query->join('part_bin_location as bin', 'bin.part_master_id', '=', 'part_master.id')
            ->where('bin.tbl_bin_id', $bin_id);
    }

    public function scopeSearchSource($query, $source)
    {
        $searchQueries = preg_split('/\s+/', $source, -1, PREG_SPLIT_NO_EMPTY);
        if ($source != null) 
            $query->join('part_source_description', 'part_source_description.part_master_id', '=', 'part_master.id')
            ->join('part_source_equipment_code', 'part_source_equipment_code.part_master_id', '=', 'part_master.id')
            ->join('part_source_part_number', 'part_source_part_number.part_master_id', '=', 'part_master.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    // part source description
                    $q->orWhere('inc', 'like', '%'.$value.'%')
                    ->orWhere('item_name', 'like', '%'.$value.'%')
                    ->orWhere('group_class', 'like', '%'.$value.'%')
                    ->orWhere('unit_issue', 'like', '%'.$value.'%')
                    ->orWhere('short', 'like', '%'.$value.'%')
                    ->orWhere('source', 'like', '%'.$value.'%')
                    // part source part number
                    ->orWhere('part_source_part_number.manufacturer_code', 'like', '%'.$value.'%')
                    ->orWhere('manufacturer', 'like', '%'.$value.'%')
                    ->orWhere('manufacturer_ref', 'like', '%'.$value.'%')
                    ->orWhere('ref_type', 'like', '%'.$value.'%')
                    // part source equipment code
                    ->orWhere('equipment_code', 'like', '%'.$value.'%')
                    ->orWhere('equipment_name', 'like', '%'.$value.'%')
                    ->orWhere('qty_install', 'like', '%'.$value.'%')
                    ->orWhere('part_source_equipment_code.manufacturer_code', 'like', '%'.$value.'%')
                    ->orWhere('manufacturer_name', 'like', '%'.$value.'%')
                    ->orWhere('doc_ref', 'like', '%'.$value.'%')
                    ->orWhere('dwg_ref', 'like', '%'.$value.'%');
                }
            });
    }
}