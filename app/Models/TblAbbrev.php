<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblAbbrev extends Model
{
    protected $table = 'tbl_abbrev';
    protected $fillable = array(
		'abbrev',
		'full_text',
		'created_by',
		'last_updated_by'
		);
}
