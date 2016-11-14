<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class PartColloquial extends Model
{
	protected $table = 'part_colloquial';
    protected $fillable = array(
    	'part_master_id', 'tbl_colloquial_id', 'created_by',
    	'last_updated_by'
    	);

    public function getPartColloquialIdAttribute()
    {
        return Hashids::encode($this->attributes['part_colloquial_id']);
    }    
}
