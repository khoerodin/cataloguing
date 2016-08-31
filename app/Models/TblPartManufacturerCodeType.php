<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPartManufacturerCodeType extends Model
{
    protected $table = 'tbl_part_manufacturer_code_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
