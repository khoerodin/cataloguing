<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class TblPartAttachment extends Model
{
    protected $table = 'tbl_part_attachment';
  	protected $fillable = array(
		'type',
		'title',
		'url',								    	
		'source' //web url or document etc...
		);

  	public function getTblPartAttachmentIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_part_attachment_id']);
    }
}
