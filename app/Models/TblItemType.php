<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblItemType extends Model
{
    protected $table = 'tbl_item_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
