<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyValue extends Model
{
    protected $table = 'company_value';
    protected $fillable = array(
    	'tbl_company_id','link_inc_characteristic_value_id',
    	'custom_value_name', 'abbrev',
    	'approved','created_by','last_updated_by'
    	);
}
