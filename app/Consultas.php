<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    protected $fillable = [
        'codigo','profissional_id', 'valor','data','nome_paciente','telefone_paciente',
        'prioridade','observacao', 'user_id'
        ];
}
