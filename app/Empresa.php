<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

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


}
