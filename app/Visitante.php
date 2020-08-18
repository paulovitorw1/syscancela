<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $primaryKey = 'visitante_id';

    protected $table = 'visitante';

    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'ultima_atualizacao';

    protected $guarded = [];
}
