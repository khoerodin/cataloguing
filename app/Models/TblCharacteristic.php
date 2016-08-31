<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCharacteristic extends Model
{
    protected $table = 'tbl_characteristic';
    protected $fillable = array(
    	'characteristic',
    	'label',
    	'position',
    	'space',
    	'type',
    	'created_by',
    	'last_updated_by'
    	);

    public function linkIncCharacteristic()
    {
        return $this->hasMany('App\LinkIncCharacteristic');
    }
}
