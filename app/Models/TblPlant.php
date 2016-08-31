<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

		public function scopeSearchHolding($query, $holdingId)
    {
      if ($holdingId) $query->where('tbl_holding_id', $holdingId);
    }

    public function scopeSearchCompany($query, $companyId)
    {
      if ($companyId) $query->where('tbl_company_id', $companyId);
    }
}
