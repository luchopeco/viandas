<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $table = 'alimento';

    protected $fillable = ['nombre', 'descripcion','estado','tipo_alimento_id'];

    protected $primaryKey="id";

    public function TipoAlimento()
    {
        return $this->hasOne('viandas\TipoAlimento', 'id','tipo_alimento_id');
    }


    public function ListClientesNoMeGusta()
    {
        return $this->belongsToMany('viandas\Cliente', 'no_me_gusta', 'alimento_id', 'cliente_id');
    }

}
