<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class TipoAlimento extends Model
{
    protected $table = 'tipo_alimento';

    protected $fillable = ['nombre', 'descripcion'];

    protected $primaryKey="id";

}
