<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
       	protected $table = 'membresias';
		protected $primaryKey = 'id_membresia';
		protected $guarded = [];
}
