<?php

namespace viandas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $fillable = ['estado', 'envio', 'cliente_id', 'fecha_pedido','cadete_id',
        'cobrado','precio_envio','observaciones','pedido_empresa_id','total'];

    protected $primaryKey="id";


    public function Cliente()
    {
        return $this->hasOne('viandas\Cliente', 'id', 'cliente_id');
    }

    public function ListLineasPedido()
    {
        return $this->hasMany('viandas\LineaPedido','pedido_id', 'id');
    }

    public function Cadete()
    {
        return $this->hasOne('viandas\Cadete', 'id', 'cadete_id');
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
