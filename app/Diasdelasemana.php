<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Diasdelasemana extends Model
{
    protected $table = 'dia_semana';

    protected $fillable = ['nombre', 'descripcion'];

    protected $primaryKey="id";

    public function ListClientes()
    {
        return $this->belongsToMany('viandas\Clientes','cliente_dia', 'dia_semana_id','cliente_id');
    }

}
