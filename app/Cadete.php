<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cadete extends Model


{
	 use SoftDeletes;
	 
    protected $table = 'cadete';

    protected $fillable = ['nombre', 'apellido', 'telefono','email'];

    protected $primaryKey="id";

    public function NombreApellido()
    {
        return $this->nombre . " ". $this->apellido;
    }
}
