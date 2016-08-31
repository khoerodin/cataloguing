<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblInc extends Model
{
    protected $table = 'tbl_inc';
    protected $fillable = array(
    	'inc',
    	'item_name',
    	'short_name',
    	'sap_code',
    	'sap_char_id',
    	'eng_definition',
    	'ind_definition',
    	'created_by',
    	'last_updated_by'
    	);

    public function scopeSearchInc($query, $inc)
    {
      if ($inc) $query->where('inc', 'like', '%'.$inc.'%');
    }

    public function scopeSearchItemName($query, $item_name)
    {
      if ($item_name) $query->where('item_name', 'like', '%'.$item_name.'%');
    }

    public function scopeSearchColloquial($query, $tbl_colloquial_id)
    {
      if ($tbl_colloquial_id)
        $query->leftJoin('link_inc_colloquial', 'link_inc_colloquial.tbl_inc_id', '=', 'tbl_inc.id')
        ->where('tbl_colloquial_id', $tbl_colloquial_id);
    }

    public function scopeSearchGroup($query, $tbl_group_id)
    {
      if ($tbl_group_id) $query->where('tbl_group_id', trim($tbl_group_id));
    }

    public function scopeSearchClass($query, $tbl_group_class_id)
    {
      if ($tbl_group_class_id) $query->where('tbl_group_class_id', $tbl_group_class_id);
    }

    public function scopeSearchCharacteristic($query, $tbl_characteristic_id)
    {
      if ($tbl_characteristic_id) $query->leftJoin('link_inc_characteristic', 'link_inc_characteristic.tbl_inc_id', '=', 'tbl_inc.id')
        ->where('tbl_characteristic_id', $tbl_characteristic_id);
    }

    public function linkIncCharacteristic()
    {
        return $this->hasMany('App\LinkIncCharacteristic');
    }
}
