<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class PartAttachment extends Model
{
    protected $table = 'part_attachment';
  	protected $fillable = array(
		'tbl_part_attachment_id',
		'part_master_id'
		);

  	public function getPartAttachmentIdAttribute()
    {
        return Hashids::encode($this->attributes['part_attachment_id']);
    }

    public function getTblPartAttachmentIdAttribute()
    {
        return Hashids::encode($this->attributes['tbl_part_attachment_id']);
    }

    public function getPartMasterIdAttribute()
    {
        return Hashids::encode($this->attributes['part_master_id']);
    }
}
