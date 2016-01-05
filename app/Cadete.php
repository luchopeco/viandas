<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Cadete extends Model
{
    protected $table = 'cadete';

    protected $fillable = ['nombre', 'apellido', 'telefono','email'];

    protected $primaryKey="id";

    public function NombreApellido()
    {
        return $this->nombre . " ". $this->apellido;
    }
}
