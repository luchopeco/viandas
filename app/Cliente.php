<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $fillable = ['nombre', 'apellido','dni','domicilio', 'email','estado_deuda','valor_deuda','estado'];

    protected $primaryKey="id";

    public function ListAlimentosNoMeGusta()
    {
        return $this->belongsToMany('viandas\Alimento', 'no_me_gusta', 'cliente_id', 'alimento_id');
    }

}
