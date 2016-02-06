<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'cliente';


    protected $fillable = ['nombre', 'apellido','dni','domicilio', 'email','telefono','estado_deuda','valor_deuda','estado','idlocalidad','idempresa','envio'];

    protected $primaryKey="id";

    public function ListAlimentosNoMeGusta()
    {
        return $this->belongsToMany('viandas\Alimento', 'no_me_gusta', 'cliente_id', 'alimento_id');
    }

    public function ListDiasDeLaSemana()
    {
        return $this->belongsToMany('viandas\DiaSemana','cliente_dia', 'cliente_id','dia_semana_id');
    }

    public function ListViandas()
    {
        return $this->hasMany('viandas\ViandaCliente', 'cliente_id','id');
    }

    public function Localidad()
    {
        return $this->hasOne('viandas\Localidad', 'id','idlocalidad');
    }

    public function Empresa()
    {
        return $this->hasOne('viandas\Empresa', 'id','idempresa');
    }


}
