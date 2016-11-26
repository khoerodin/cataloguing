<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class PartBinLocation extends Model
{
    protected $table = 'part_bin_location';
    protected $fillable = array(
    	'part_master_id', 'tbl_company_id', 'tbl_plant_id', 'tbl_location_id',
    	'tbl_shelf_id', 'tbl_bin_id', 'stock_on_hand', 'tbl_unit_of_measurement_id',
    	'created_by','last_updated_by'
    	);

    public function getTblCompanyIdAttribute()
	{
        return Hashids::encode($this->attributes['tbl_company_id']);
	}
}
