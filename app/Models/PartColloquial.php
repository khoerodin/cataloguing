<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartColloquial extends Model
{
	protected $table = 'part_colloquial';
    protected $fillable = array(
    	'part_master_id', 'tbl_colloquial_id', 'created_by',
    	'last_updated_by'
    	);
}
