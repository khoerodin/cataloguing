<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblBin extends Model
{
    protected $table = 'tbl_bin';
    protected $fillable = array(
	    	'bin',
	    	'description',
	    	'tbl_shelf_id',
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

    public function scopeSearchShelf($query, $shelfId)
    {
      if ($shelfId) $query->where('tbl_shelf_id', $shelfId);
    }
}
