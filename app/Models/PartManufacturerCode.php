<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartManufacturerCode extends Model
{
    protected $table = 'part_manufacturer_code';
    protected $fillable = array(
    	'part_master_id', 'tbl_manufacturer_code_id', 'tbl_source_type_id',
    	'manufacturer_ref', 'tbl_part_manufacturer_code_type_id', 
    	'created_by','last_updated_by'
    	);
}
