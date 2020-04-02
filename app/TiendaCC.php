<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiendaCC extends Model
{
    protected $table = 'tiendas_cc';
	protected $primaryKey = 'id_tda';
	protected $guarded = [];
}
