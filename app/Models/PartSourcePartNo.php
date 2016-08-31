<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartSourcePartNo extends Model
{
    protected $table = 'part_source_part_no';
    protected $fillable = array(
    	'part_master_id', 'manufacturer_code', 'manufacturer', 'manufacturer_ref', 'ref_type', 'created_by', 'last_updated_by'
    	);
}
