<?php

namespace viandas;

use Illuminate\Database\Eloquent\Model;

class NoLaborables extends Model
{
    protected $table = 'no_laborables';

    protected $fillable = ['fecha', 'motivo','estado'];

    protected $primaryKey="id";

}
