<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartCharacteristicValue extends Model
{
	protected $table = 'part_characteristic_value';
    protected $fillable = array(
    	'part_master_id', 'link_inc_characteristic_value_id',
    	'short', 'created_by','last_updated_by'
    	);
}
