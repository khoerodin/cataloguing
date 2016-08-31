<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblHolding extends Model
{
    protected $table = 'tbl_holding';
    protected $fillable = array(
    	'holding',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
