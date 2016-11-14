<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class LinkIncGroupClass extends Model
{
    protected $table = 'link_inc_group_class';
    protected $fillable = array(
    	'tbl_inc_id','tbl_group_class_id',
    	'sequence','created_by','last_updated_by'
    	);

    public function getIncIdAttribute()
	{
        return Hashids::encode($this->attributes['inc_id']);
	}

    public function getGroupClassIdAttribute()
    {
        return Hashids::encode($this->attributes['group_class_id']);
    }
}
