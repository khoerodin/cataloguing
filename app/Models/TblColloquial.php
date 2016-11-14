<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblColloquial extends Model
{
    protected $table = 'tbl_colloquial';
    protected $fillable = array(
    	'colloquial',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblColloquialIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_colloquial_id']);
    }
}
