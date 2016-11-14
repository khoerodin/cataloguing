<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblLocation extends Model
{
    protected $table = 'tbl_location';
    protected $fillable = array(
	    	'location',
	    	'description',
	    	'tbl_plant_id',										    	
	    	'created_by',
	    	'last_updated_by'
	    	);

    public function getTblLocationIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_location_id']);
    }

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
