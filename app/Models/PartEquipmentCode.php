<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartEquipmentCode extends Model
{
    protected $table = 'part_equipment_code';
    protected $fillable = array(
    	'part_master_id', 'tbl_equipment_code_id', 'qty_install',
    	'doc_ref', 'dwg_ref', 'tbl_manufacturer_code_id', 'created_by',
    	'last_updated_by'
    	);
}
