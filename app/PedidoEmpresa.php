<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class PedidoEmpresa extends Model
{
    protected $table = 'pedido_empresa';

    protected $fillable = ['empresa_id', 'envio', 'fecha_pedido','cadete_id',
        'cobrado','precio_envio','observaciones','total'];

    protected $primaryKey="id";

    public function Cadete()
    {
        return $this->hasOne('viandas\Cadete', 'id', 'cadete_id');
    }
    public function Empresa()
    {
        return $this->hasOne('viandas\Empresa', 'id', 'empresa_id');
    }
    public function ListPedidos()
    {
        return $this->hasMany('viandas\Pedido','pedido_empresa_id', 'id');
    }

}
