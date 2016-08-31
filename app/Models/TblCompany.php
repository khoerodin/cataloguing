<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCompany extends Model
{
  	protected $table = 'tbl_company';  
  	protected $fillable = array(
		'company',
		'description',
		'tbl_holding_id',								    	
		'created_by',
		'last_updated_by'
		);

	public function scopeSearchHolding($query, $holdingId)
	{
	if ($holdingId) $query->where('tbl_holding_id', $holdingId);
	}
}
