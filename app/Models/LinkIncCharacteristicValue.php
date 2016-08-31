<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkIncCharacteristicValue extends Model
{
    protected $table = 'link_inc_characteristic_value';
    protected $fillable = array(
    	'link_inc_characteristic_id','value','abbrev','approved',
    	'created_by','last_updated_by'
    	);

    public function linkIncCharacteristic() {
		return $this->belongsTo('App\LinkIncCharacteristic');
	}
}
