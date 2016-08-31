<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblWeightUnit extends Model
{
    protected $table = 'tbl_weight_unit';
    protected $fillable = array(
    	'unit',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
