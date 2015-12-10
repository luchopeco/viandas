<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';

    protected $fillable = ['nombre', 'idlocalidad'];

    protected $primaryKey="id";

    public function Localidad()
    {
        return $this->hasOne('viandas\Localidad', 'id','idlocalidad');
    }
}
