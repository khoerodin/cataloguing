<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class PartEquipmentCode extends Model
{
    protected $table = 'part_equipment_code';
    protected $fillable = array(
    	'part_master_id', 'tbl_equipment_code_id', 'qty_install',
        'drawing_ref', 'tbl_manufacturer_code_id', 'created_by',
    	'last_updated_by'
    	);

    public function getPartEquipmentCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['part_equipment_code_id']);
    }

    public function getPartMasterIdAttribute()
    {
        return Hashids::encode($this->attributes['part_master_id']);
    }

    public function getTblEquipmentCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_equipment_code_id']);
    }
    
    public function getTblManufacturerCodeIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_manufacturer_code_id']);
    }
}
