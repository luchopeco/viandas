<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{
    protected $table = 'empresa';

    protected $fillable = ['nombre', 'idlocalidad','envio'];

    protected $primaryKey="id";

    public function Localidad()
    {
        return $this->hasOne('viandas\Localidad', 'id','idlocalidad');
    }
    public function Envio()
    {
        if($this->envio==1)
        {
            return 'SI';
        }
        else{
            return 'NO';
        }
    }


    public function ListPreciosViandas()
    {
        return $this->belongsToMany('viandas\TipoVianda','empresa_vianda','empresa_id','tipo_vianda_id')->withPivot('precio');
    }

    public function getPrecioVianda($idTipoVianda)
    {

        $tabla = DB::select(DB::raw("SELECT CASE COUNT(ev.precio) WHEN 0 THEN (SELECT tv.precio FROM tipo_vianda tv WHERE tv.id =:p1)  ELSE ev.precio  END precio
                                        FROM empresa_vianda ev
                                        WHERE ev.empresa_id=:p2 AND ev.tipo_vianda_id=:p3"), array(
            'p1' => $idTipoVianda,'p2' => $this->id,'p3' => $idTipoVianda));

        return $tabla[0]->precio;
    }


}
