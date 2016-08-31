<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCatalogStatus extends Model
{
    protected $table = 'tbl_catalog_status';
    protected $fillable = array(
    	'status',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);
}
