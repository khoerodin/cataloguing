<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyShortDescriptionFormat extends Model
{
    protected $table = 'company_short_description_format';
    protected $fillable = array(
    	'company_characteristic_id', 'separator',
    	'sequence',	'hidden', 'created_by','last_updated_by'
    	);
}
