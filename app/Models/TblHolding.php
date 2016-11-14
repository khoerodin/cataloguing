<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblHolding extends Model
{
    protected $table = 'tbl_holding';
    protected $fillable = array(
    	'holding',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblHoldingIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_holding_id']);
    }
}
