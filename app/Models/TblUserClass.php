<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblUserClass extends Model
{
    protected $table = 'tbl_user_class';
    protected $fillable = array(
    	'class',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
