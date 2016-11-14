<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class LinkIncCharacteristicValue extends Model
{
    protected $table = 'link_inc_characteristic_value';
    protected $fillable = array(
    	'link_inc_characteristic_id','value','abbrev','approved',
    	'created_by','last_updated_by'
    	);

    public function getLinkIncCharacteristicValueIdAttribute()
    {
        return Hashids::encode($this->attributes['link_inc_characteristic_value_id']);
    }

    public function getCompanyValueIdAttribute()
    {
        return Hashids::encode($this->attributes['company_value_id']);
    }

    public function getLinkIncCharacteristicIdAttribute()
    {
        return Hashids::encode($this->attributes['link_inc_characteristic_id']);
    }    

    public function linkIncCharacteristic() {
		return $this->belongsTo('App\LinkIncCharacteristic');
	}
}
