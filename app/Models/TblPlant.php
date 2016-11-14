<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblPlant extends Model
{
    protected $table = 'tbl_plant';
    protected $fillable = array(
    	'plant',										    	
    	'description',
    	'tbl_company_id',
    	'created_by',
    	'last_updated_by'
    	);
    
    public function getTblPlantIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_plant_id']);
    }

	public function scopeSearchHolding($query, $holdingId)
    {
      if ($holdingId) $query->where('tbl_holding_id', $holdingId);
    }

    public function scopeSearchCompany($query, $companyId)
    {
      if ($companyId) $query->where('tbl_company_id', $companyId);
    }
}
