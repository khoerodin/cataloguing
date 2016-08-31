<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCharacteristicSequence extends Model
{
	protected $table = 'company_characteristic_sequence';
    protected $fillable = array(
    	'tbl_company_id','link_inc_characteristic_id', 'sequence',
    	'created_by','last_updated_by'
    	);
}
