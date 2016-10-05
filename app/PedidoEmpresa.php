<?php

namespace viandas;

use Carbon\Carbon;
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
    public function FueCobrado(){
        if($this->cobrado==1)
        {
            return "SI";
        }
        else
        {
            return "NO";
        }
    }
    public function FechaPedido()
    {

        if($this->fecha_pedido!="")
        {return  Carbon::createFromFormat('Y-m-d', $this->fecha_pedido)->format('d/m/Y');}

    }

}
