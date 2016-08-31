<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkIncGroupClass extends Model
{
    protected $table = 'link_inc_group_class';
    protected $fillable = array(
    	'tbl_inc_id','tbl_group_class_id',
    	'sequence','created_by','last_updated_by'
    	);
}
