<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    protected $fillable = [
        'codigo','nome', 'telefone','data_nascimento','cpf','rg','email','celular',
        'sexo','observacao', 'user_id'
        ];
}
