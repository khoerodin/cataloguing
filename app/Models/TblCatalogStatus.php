<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblCatalogStatus extends Model
{
    protected $table = 'tbl_catalog_status';
    protected $fillable = array(
    	'status',
    	'description',
    	'created_by',
    	'last_updated_by'
    	);

    public function getTblCatalogStatusIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_catalog_status_id']);
    }
}
