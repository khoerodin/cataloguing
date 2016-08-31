<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblHazardClass extends Model
{
    protected $table = 'tbl_hazard_class';
    protected $fillable = array(
    	'class',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
