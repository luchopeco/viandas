<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidad';

    protected $fillable = ['nombre', 'costo_envio'];

    protected $primaryKey="id";
}
