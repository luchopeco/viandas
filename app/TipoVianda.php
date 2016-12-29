<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class TipoVianda extends Model
{
    protected $table = 'tipo_vianda';

    protected $fillable = ['nombre', 'descripcion','precio','abrev'];

    protected $primaryKey="id";
}
