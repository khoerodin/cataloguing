<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblUnitOfMeasurement extends Model
{
    protected $table = 'tbl_unit_of_measurement';
    protected $fillable = array(
    	'unit4',
    	'unit3',
    	'unit2',
    	'description',
    	'eng_definition',
    	'ind_definition',
    	'created_by',
    	'last_updated_by'
    	);
}
