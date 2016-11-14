<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CompanyCharacteristic extends Model
{
    protected $table = 'company_characteristic';
    protected $fillable = array(
    	'tbl_company_id','link_inc_characteristic_id','custom_char_name','sequence','tbl_po_style_id','hidden', 'created_by','last_updated_by'
    	);

    public function getCompanyCharacteristicIdAttribute()
    {
        return Hashids::encode($this->attributes['company_characteristic_id']);
    }

    public function getLinkIncCharacteristicIdAttribute()
    {
        return Hashids::encode($this->attributes['link_inc_characteristic_id']);
    }

    public function getTblPoStyleIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_po_style_id']);
    }
}
