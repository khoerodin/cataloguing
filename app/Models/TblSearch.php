<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblSearch extends Model
{
    protected $table = 'tbl_search';
    protected $fillable = array(
    	'catalog_no', 'holding_no', 'inc_id', 'colloquial_id', 'group_class_id', 'catalog_status_id', 'catalog_type', 'item_type_id', 'man_code_id', 'part_number', 'equipment_code_id', 'holding_id', 'company_id', 'plant_id', 'location_id', 'shelf_id', 'bin_id'
    	);

    public function scopeSearchCatalogNo($query, $catalog_no)
    {
        if ($catalog_no == null){
        	$query
        		->where('catalog_no', '')
        		->orWhereNull('catalog_no');
        }else{
        	$query->where('catalog_no', $catalog_no);
        }
    }

    public function scopeSearchHoldingNo($query, $holding_no)
    {
        if ($holding_no == null){
        	$query
        		->where('holding_no', '')
        		->orWhereNull('holding_no');
        }else{
        	$query->where('holding_no', $holding_no);
        }
    }

    public function scopeSearchIncId($query, $inc_id)
    {
        if ($inc_id == null){
        	$query
        		->where('inc_id', '')
        		->orWhereNull('inc_id');
        }else{
        	$query->where('inc_id', $inc_id);
        }
    }

    public function scopeSearchColloquialId($query, $colloquialId)
    {
        if ($colloquialId == null){
        	$query
        		->where('colloquial_id', '')
        		->orWhereNull('colloquial_id');
        }else{
        	$query->where('colloquial_id', $colloquialId);
        }
    }

    public function scopeSearchGroupClassId($query, $group_class_id)
    {
        if ($group_class_id == null){
        	$query
        		->where('group_class_id', '')
        		->orWhereNull('group_class_id');
        }else{
        	$query->where('group_class_id', $group_class_id);
        }
    }

    public function scopeSearchCatalogStatusId($query, $catalog_status_id)
    {
        if ($catalog_status_id == null){
        	$query
        		->where('catalog_status_id', '')
        		->orWhereNull('catalog_status_id');
        }else{
        	$query->where('catalog_status_id', $catalog_status_id);
        }
    }

    public function scopeSearchCatalogType($query, $catalog_type)
    {
        if ($catalog_type == null){
        	$query
        		->where('catalog_type', '')
        		->orWhereNull('catalog_type');
        }else{
        	$query->where('catalog_type', $catalog_type);
        }
    }

    public function scopeSearchItemTypeId($query, $item_type_id)
    {
        if ($item_type_id == null){
        	$query
        		->where('item_type_id', '')
        		->orWhereNull('item_type_id');
        }else{
        	$query->where('item_type_id', $item_type_id);
        }
    }

    public function scopeSearchManCodeId($query, $man_code_id)
    {
        if ($man_code_id == null){
        	$query
        		->where('man_code_id', '')
        		->orWhereNull('man_code_id');
        }else{
        	$query->where('man_code_id', $man_code_id);
        }
    }

    public function scopeSearchPartNumber($query, $part_number)
    {
        if ($part_number == null){
        	$query
        		->where('part_number', '')
        		->orWhereNull('part_number');
        }else{
        	$query->where('part_number', $part_number);
        }
    }

    public function scopeSearchEquipmentCodeId($query, $equipment_code_id)
    {
        if ($equipment_code_id == null){
        	$query
        		->where('equipment_code_id', '')
        		->orWhereNull('equipment_code_id');
        }else{
        	$query->where('equipment_code_id', $equipment_code_id);
        }
    }

    public function scopeSearchHoldingId($query, $holding_id)
    {
        if ($holding_id == null){
        	$query
        		->where('holding_id', '')
        		->orWhereNull('holding_id');
        }else{
        	$query->where('holding_id', $holding_id);
        }
    }

    public function scopeSearchCompanyId($query, $company_id)
    {
        if ($company_id == null){
        	$query
        		->where('company_id', '')
        		->orWhereNull('company_id');
        }else{
        	$query->where('company_id', $company_id);
        }
    }

    public function scopeSearchPlantId($query, $plant_id)
    {
        if ($plant_id == null){
        	$query
        		->where('plant_id', '')
        		->orWhereNull('plant_id');
        }else{
        	$query->where('plant_id', $plant_id);
        }
    }

    public function scopeSearchLocationId($query, $location_id)
    {
        if ($location_id == null){
        	$query
        		->where('location_id', '')
        		->orWhereNull('location_id');
        }else{
        	$query->where('location_id', $location_id);
        }
    }

    public function scopeSearchShelfId($query, $shelf_id)
    {
        if ($shelf_id == null){
        	$query
        		->where('shelf_id', '')
        		->orWhereNull('shelf_id');
        }else{
        	$query->where('shelf_id', $shelf_id);
        }
    }

    public function scopeSearchBinId($query, $bin_id)
    {
        if ($bin_id == null){
        	$query
        		->where('bin_id', '')
        		->orWhereNull('bin_id');
        }else{
        	$query->where('bin_id', $bin_id);
        }
    }
}
