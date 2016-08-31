<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyShortDescriptionFormat extends Model
{
    protected $table = 'company_short_description_format';
    protected $fillable = array(
    	'tbl_company_id','short_description_format_id', 'separator',
    	'sequence',	'created_by','last_updated_by'
    	);
}
