<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblEquipmentPlant extends Model
{
    protected $table = 'tbl_equipment_plant';
    protected $fillable = array(
    	'tbl_equipment_code_id',
    	'tbl_plant_id'
    	);

}
