<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $fillable = ['cantidad', 'estado', 'envio', 'cliente_id', 'tipo_vianda_id', 'fecha_pedido','cadete_id', 'cobrado','precio_vianda','precio_envio'];

    protected $primaryKey="id";

    public function Cliente()
    {
        return $this->hasOne('viandas\Cliente', 'id', 'cliente_id');
    }

    public function TipoVianda()
    {
        return $this->hasOne('viandas\TipoVianda', 'id', 'tipo_vianda_id');
    }

    public function Cadete()
    {
        return $this->hasOne('viandas\Cadete', 'id', 'cadete_id');
    }
}
