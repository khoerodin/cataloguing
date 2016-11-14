<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class PartManufacturerCode extends Model
{
    protected $table = 'part_manufacturer_code';
    protected $fillable = array(
    	'part_master_id', 'tbl_manufacturer_code_id', 'tbl_source_type_id',
    	'manufacturer_ref', 'tbl_part_manufacturer_code_type_id', 
    	'created_by','last_updated_by'
    	);

    public function getPartManufacturerCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['part_manufacturer_code_id']);
    }

    public function getTblManufacturerCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_manufacturer_code_id']);
    }

    public function getTblSourceTypeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_source_type_id']);
    }

    public function getTblPartManufacturerCodeTypeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_part_manufacturer_code_type_id']);
    }
}
