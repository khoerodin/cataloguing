<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class LinkIncCharacteristic extends Model
{
    protected $table = 'link_inc_characteristic';
    protected $fillable = array(
    	'tbl_inc_id','tbl_characteristic_id','characteristic',
    	'default_short_separator','sequence','created_by','last_updated_by'
    	);

    public function getLinkIncCharacteristicIdAttribute()
    {
        return Hashids::encode($this->attributes['link_inc_characteristic_id']);
    }

    public function getPartMasterIdAttribute()
    {
        return Hashids::encode($this->attributes['part_master_id']);
    }

    public function getTblIncIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_inc_id']);
    }

    public function getLinkIncCharacteristicValueIdAttribute()
    {
        return Hashids::encode($this->attributes['link_inc_characteristic_value_id']);
    }

    public function getPartCharacteristicValueIdAttribute()
    {
        return Hashids::encode($this->attributes['part_characteristic_value_id']);
    }

    public function getCharIdAttribute()
    {
        return Hashids::encode($this->attributes['char_id']);
    }

    public function linkIncCharacteristicValue() {
		return $this->hasMany('App\LinkIncCharacteristicValue');
	}

    public function tblInc()
    {
        return $this->belongsTo('App\TblInc');
    }

    public function tblCharacteristic()
    {
        return $this->belongsTo('App\TblCharacteristic');
    }
}
