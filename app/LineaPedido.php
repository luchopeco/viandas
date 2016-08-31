<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class LineaPedido extends Model
{
    protected $table = 'linea_pedido';


    protected $fillable = ['pedido_id', 'tipo_vianda_id', 'precio_vianda', 'cantidad'];

    protected $primaryKey="id";

    public function TipoVianda()
    {

        return $this->hasOne('viandas\TipoVianda', 'id', 'tipo_vianda_id');
    }

    public function Pedido()
    {

        return $this->belongsTo('viandas\Pedido', 'id', 'pedido_id');
    }

}
