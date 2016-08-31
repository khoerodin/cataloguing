<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblShelf extends Model
{
    protected $table = 'tbl_shelf';
    protected $fillable = array(
	    	'shelf',
	    	'description',
	    	'tbl_location_id',										    	
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

    public function scopeSearchLocation($query, $locationId)
    {
      if ($locationId) $query->where('tbl_location_id', $locationId);
    }
}
