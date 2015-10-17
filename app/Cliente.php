<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $fillable = ['nombre', 'apellido','dni','domicilio', 'email','estadoDeuda','valorDeuda','estado'];

    protected $primaryKey="id";

}
