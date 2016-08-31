<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblColloquial extends Model
{
    protected $table = 'tbl_colloquial';
    protected $fillable = array(
    	'colloquial',
    	'created_by',
    	'last_updated_by'
    	);
}
