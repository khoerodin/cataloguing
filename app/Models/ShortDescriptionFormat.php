<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortDescriptionFormat extends Model
{
    protected $table = 'short_description_format';
    protected $fillable = array(
    	'link_inc_characteristic_id','separator', 'sequence',
    	'created_by','last_updated_by'
    	);
}
