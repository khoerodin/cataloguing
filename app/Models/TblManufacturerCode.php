<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblManufacturerCode extends Model
{
    protected $table = 'tbl_manufacturer_code';
    protected $fillable = array(
    	'manufacturer_code',
    	'manufacturer_name',
    	'address',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblManufacturerCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_manufacturer_code_id']);
    }
}
