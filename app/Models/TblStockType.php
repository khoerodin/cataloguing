<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblStockType extends Model
{
    protected $table = 'tbl_stock_type';
    protected $fillable = array(
    	'type',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
