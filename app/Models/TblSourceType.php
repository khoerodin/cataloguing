<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblSourceType extends Model
{
    protected $table = 'tbl_source_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
