<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblHarmonizedCode extends Model
{
    protected $table = 'tbl_harmonized_code';
    protected $fillable = array(
    	'code',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
