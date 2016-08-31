<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCheckShort extends Model
{
    protected $table = 'company_check_short';
    protected $fillable = array(
    	'tbl_company_id','part_characteristic_value_id', 'short',
    	'created_by','last_updated_by'
    	);
}
