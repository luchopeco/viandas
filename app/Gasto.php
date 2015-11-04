<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gasto';

    protected $fillable = ['descripcion', 'idtipo_gasto', 'monto', 'fecha'];

    protected $primaryKey="id";

    public function TipoGasto()
    {
        return $this->hasOne('viandas\TipoGasto', 'id','idtipo_gasto');
    }
}
