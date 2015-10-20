<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'cliente';

    protected $fillable = ['nombre', 'apellido','dni','domicilio', 'email','estado_deuda','valor_deuda','estado'];

    protected $primaryKey="id";

    public function ListAlimentosNoMeGusta()
    {
        return $this->belongsToMany('viandas\Alimento', 'no_me_gusta', 'cliente_id', 'alimento_id');
    }

}
