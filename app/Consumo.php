<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    protected $table = 'consumos';
	protected $primaryKey = 'id_consumo';
	protected $guarded = [];
}
