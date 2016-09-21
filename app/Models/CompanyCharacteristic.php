<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCharacteristic extends Model
{
    protected $table = 'company_characteristic';
    protected $fillable = array(
    	'tbl_company_id','link_inc_characteristic_id', 'sequence',
    	'hidden', 'created_by','last_updated_by'
    	);
}
