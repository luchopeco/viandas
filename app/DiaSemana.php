<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    protected $table = 'dia_semana';

    protected $fillable = ['nombre', 'descripcion'];

    protected $primaryKey="id";

    public function ListViandasClientes()
    {
        return $this->hasMany('viandas\ViandaCliente', 'dia_semana_id','id')->whereRaw('cliente_id not in (select id from cliente where deleted_at is not null)');
    }


}
