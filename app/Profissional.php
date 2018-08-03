<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    protected $fillable = [
        'codigo','nome', 'especialidade','observacao','telefone','email','user_id'
        ];
}
