<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblSourceType extends Model
{
    protected $table = 'tbl_source_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblSourceTypeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_source_type_id']);
    }
}
