<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class LineaPedido extends Model
{
    protected $table = 'linea_pedido';



    protected $fillable = ['pedido_id', 'tipo_vianda_id', 'precio_vianda', 'cantidad'];

    protected $primaryKey="id";

    //lo utilizo cuando paso un pedido al listado para filtrar por dia
    public $dia_id;

    public function TipoVianda()
    {

        return $this->hasOne('viandas\TipoVianda', 'id', 'tipo_vianda_id');
    }

    public function Pedido()
    {

        return $this->belongsTo('viandas\Pedido', 'id', 'pedido_id');
    }

}
