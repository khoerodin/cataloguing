<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCharacteristic extends Model
{
    protected $table = 'company_characteristic';
    protected $fillable = array(
    	'tbl_company_id','link_inc_characteristic_id','custom_char_name','sequence','tbl_po_style_id','hidden', 'created_by','last_updated_by'
    	);
}
