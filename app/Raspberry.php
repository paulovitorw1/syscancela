<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raspberry extends Model
{
    protected $table = 'raspberry';
    protected $primaryKey = 'raspberry_id';

    CONST CREATED_AT = 'data_de_criacao';
    CONST UPDATED_AT = 'ultima_atualizacao';
    
    protected $guarded = [];
}
