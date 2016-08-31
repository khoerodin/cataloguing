<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartSourceDescription extends Model
{
    protected $table = 'part_source_description';
    protected $fillable = array(
    	'part_master_id', 'inc', 'item_name', 'group_class', 'uom', 'source', 'created_by', 'last_updated_by'
    	);
}