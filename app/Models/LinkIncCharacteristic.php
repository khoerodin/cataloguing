<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkIncCharacteristic extends Model
{
    protected $table = 'link_inc_characteristic';
    protected $fillable = array(
    	'tbl_inc_id','tbl_characteristic_id','characteristic',
    	'default_separator','sequence','created_by','last_updated_by'
    	);

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
