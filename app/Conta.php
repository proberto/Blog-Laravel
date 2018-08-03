<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable = [
        'codigo','banco', 'ag','conta','dv','nometitular','cpfcnpj','radioantecipacao',
        'radiorecebimento','transfer_day', 'user_id', 'recebedor_id'
        ];
}
