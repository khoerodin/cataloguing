<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkIncColloquial extends Model
{
    protected $table = 'link_inc_colloquial';
    protected $fillable = array(
    	'tbl_inc_id',
    	'tbl_colloquial_id',
    	'created_by',
    	'last_updated_by'
    	);
}
