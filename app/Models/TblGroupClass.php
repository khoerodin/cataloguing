<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblGroupClass extends Model
{
    protected $table = 'tbl_group_class';
    protected $fillable = array(
		'tbl_group_id',
    	'class',
    	'name',
    	'eng_definition',
    	'ind_definition',   	
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblGroupClassIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_group_class_id']);
    }
}
