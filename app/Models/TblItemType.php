<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblItemType extends Model
{
    protected $table = 'tbl_item_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblItemTypeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_item_type_id']);
    }
}
