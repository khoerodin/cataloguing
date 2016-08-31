<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAbbrev extends Model
{
	protected $table = 'company_abbrev';
    protected $fillable = array(
    	'tbl_company_id','link_inc_characteristic_value_id', 'abbrev',
    	'approved','created_by','last_updated_by'
    	);
}
