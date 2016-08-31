<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblGroup extends Model
{
    protected $table = 'tbl_group';
    protected $fillable = array(
    	'group',
    	'name',
    	'created_by',
    	'last_updated_by'
    	);
}
