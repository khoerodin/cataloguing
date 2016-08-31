<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblEquipmentCode extends Model
{
    protected $table = 'tbl_equipment_code';
    protected $fillable = array(
    	'equipment_code',
    	'equipment_name',
    	'tbl_plant_id',
    	'created_by',
    	'last_updated_by'
    	);

   	public function scopeSearchHolding($query, $holdingId)
    {
      if ($holdingId) $query->where('tbl_holding_id', $holdingId);
    }

    public function scopeSearchCompany($query, $companyId)
    {
      if ($companyId) $query->where('tbl_company_id', $companyId);
    }

    public function scopeSearchPlant($query, $plantId)
    {
      if ($plantId) $query->where('tbl_plant_id', $plantId);
    }
}
