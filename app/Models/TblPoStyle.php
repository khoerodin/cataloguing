<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblPoStyle extends Model
{
    protected $table = 'tbl_po_style';
    protected $fillable = array(
    	'style_name','after_char_name','devider','after_devider',
    	'created_by','last_updated_by'
    	);

    public function getTblPoStyleIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_po_style_id']);
    }
}
