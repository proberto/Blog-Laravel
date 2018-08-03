<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'codigo','nome-serv', 'valor','parcelas','id_cartao', 'nome', 'email', 'cpf','cep','logadouro', 'numero', 'bairro', 'cidade', 'uf',
        'ddd','fone','user_id','id_transaction','valor_total','estorno'
        ];
}
