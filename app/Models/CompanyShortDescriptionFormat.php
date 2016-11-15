<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CompanyShortDescriptionFormat extends Model
{
    protected $table = 'company_short_description_format';
    protected $fillable = array(
    	'company_characteristic_id', 'short_separator',
    	'sequence',	'hidden', 'created_by','last_updated_by'
    	);

    public function getCompanyShortDescriptionFormatIdAttribute()
    {
        return Hashids::encode($this->attributes['company_short_description_format_id']);
    }
}
