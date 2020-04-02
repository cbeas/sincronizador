<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BdCC extends Model
{
    protected $table = 'bds_cc';
	protected $primaryKey = 'id_bd';
	protected $guarded = [];
}
