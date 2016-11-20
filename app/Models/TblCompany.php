<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblCompany extends Model
{
  	protected $table = 'tbl_company';
  	protected $fillable = array(
		'company',
		'description',
		'tbl_holding_id',								    	
		'uom_type',								    	
		'created_by',
		'last_updated_by'
		);

  	public function getTblCompanyIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_company_id']);
    }

	public function scopeSearchHolding($query, $holdingId)
	{
		if ($holdingId) $query->where('tbl_holding_id', $holdingId);
	}
}
