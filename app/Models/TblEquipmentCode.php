<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

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

    public function getTblEquipmentCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_equipment_code_id']);
    }

    public function getTblHoldingIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_holding_id']);
    }

    public function getTblCompanyIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_company_id']);
    }

    public function getTblPlantIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_plant_id']);
    }

   	public function scopeSearchHolding($query, $holdingId)
    {
      if ($holdingId) $query->where('tbl_holding_id', Hashids::decode($holdingId)[0]);
    }

    public function scopeSearchCompany($query, $companyId)
    {
      if ($companyId) $query->where('tbl_company_id', Hashids::decode($companyId)[0]);
    }

    public function scopeSearchPlant($query, $plantId)
    {
      if ($plantId) $query->where('tbl_plant_id', Hashids::decode($plantId)[0]);
    }
}
