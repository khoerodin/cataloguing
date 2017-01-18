<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblUserTag extends Model
{
    protected $table = 'tbl_user_tag';
    protected $fillable = array(
    	'user_id',
    	'tagged_id'
    	);
}
