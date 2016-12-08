<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartSourceEqCode extends Model
{
    protected $table = 'part_source_eq_code';
    protected $fillable = array(
    	'part_master_id', 'equipment_code', 'equipment_name', 'qty_install', 'manufacturer_code', 'manufacturer_name', 'doc_ref', 'dwg_ref'
    	);
}
