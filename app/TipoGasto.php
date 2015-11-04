<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    protected $table = 'tipo_gasto';

    protected $fillable = ['descripcion'];

    protected $primaryKey="id";
}
