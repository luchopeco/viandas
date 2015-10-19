<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class TipoAlimento extends Model
{
    protected $table = 'tipo_alimento';

    protected $fillable = ['nombre', 'descripcion'];

    protected $primaryKey="id";

    public function ListAlimentos()
    {
        return $this->hasMany('viandas\Alimento','tipo_alimento_id', 'id');
    }

}
