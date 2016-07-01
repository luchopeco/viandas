<?php

namespace viandas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $fillable = ['cantidad', 'estado', 'envio', 'cliente_id', 'tipo_vianda_id', 'fecha_pedido','cadete_id',
        'cobrado','precio_vianda','precio_envio','empresa_id','observaciones'];

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
