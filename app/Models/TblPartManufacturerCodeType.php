<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblPartManufacturerCodeType extends Model
{
    protected $table = 'tbl_part_manufacturer_code_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblPartManufacturerCodeTypeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_part_manufacturer_code_type_id']);
    }
}
