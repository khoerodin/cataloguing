<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPoStyle extends Model
{
    protected $table = 'tbl_po_style';
    protected $fillable = array(
    	'style_name','after_char_name','devider','after_devider',
    	'created_by','last_updated_by'
    	);
}
