<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CompanyCatalog extends Model
{
    protected $table = 'company_catalog';
    protected $fillable = array(
    	'part_master_id','tbl_company_id','tbl_catalog_status_id',
    	);

    public function getPartMasterIdAttribute()
    {
        return Hashids::encode($this->attributes['part_master_id']);
    }

    public function getTblCompanyIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_company_id']);
    }

    public function getTblCatalogStatusAttribute()
    {
        return Hashids::encode($this->attributes['tbl_catalog_status_id']);
    }
}
