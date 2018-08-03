<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    protected $fillable = [
        'codigo','nome-prestador', 'cnpj-cpf','cep','logradouro','cidade','uf','numero',
        'complemento','ddd','fone','whats','email','senha'
        ];
}
