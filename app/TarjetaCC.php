<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TarjetaCC extends Model
{
	protected $table = 'tarjetas_cc';
	protected $primaryKey = 'id_tarjeta';
	protected $guarded = [];

}
