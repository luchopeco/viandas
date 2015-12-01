<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
///Representa la tabla intermerdia entre los clientes, los dias de la semana, y los tipos de vianda
class ViandaCliente extends Model
{
    public $timestamps = false;

    protected $table = 'cliente_dia';

    protected $fillable = ['cliente_id','dia_semana_id','tipo_vianda_id', 'cantidad'];

    public function Cliente()
    {
        return $this->belongsTo('viandas\Cliente', 'cliente_id','id');
    }
    public function DiaSemana()
    {
        return $this->belongsTo('viandas\DiaSemana', 'dia_semana_id','id');
    }
    public function TipoVianda()
    {
        return $this->belongsTo('viandas\TipoVianda', 'tipo_vianda_id','id');
    }

}