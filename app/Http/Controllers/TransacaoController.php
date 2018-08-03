<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PagarMe;
use PagarMe_Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TransacaoController extends Controller
{
    public function index()
    {
        $array_transacoes = array();
        $array_transacoes = TransacaoController::buscarTransacoes();
        //dd($array_transacoes);

        dd($array_transacoes);

        //return view('transacoes')->with('transacoes', $array_transacoes);
    }

    public static function listarTransacoes ($id_user){

        $resultado = DB::table('vendas')->orderBy('codigo', 'desc')->where('user_id', '=', $id_user)->pluck('id_transaction');
         return $resultado;
    }

    public static function buscarTransacoes(){
        $id = Auth::id();
        $vendas = new TransacaoController;
        $arr = array();
         //PagarMe::setApiKey("ak_live_QIWpnGHuFK5lx9QOYXyvfBPWKtKMKi");
        PagarMe::setApiKey("ak_test_JSbrxmahOAw1e4x6LBoh8Mg8EBumLc");
        $arr = TransacaoController::listarTransacoes($id);
        $arr2 = array();
        $listaTransacao = array();
        foreach ($arr as $value) {
            $transaction = PagarMe_Transaction::findById("$value");
            $data_transaction = $vendas->selectTransaction($value, $id);
            $status = $transaction->status;
            $nome = $transaction->customer['name'];
            $cpf = $transaction->customer['document_number'];

            $arr2 = ["nome" => $nome, "cpf" => $cpf, "id_transaction" => $value, "status" => $status, "data" => $data_transaction['data']];
            array_push($listaTransacao, $arr2);
        }
        //dd($listaTransacao);
        return $listaTransacao;
    }

    public function imprimeRecibo($id){
        $id_transaction = $id;

         //PagarMe::setApiKey("ak_live_QIWpnGHuFK5lx9QOYXyvfBPWKtKMKi");
        PagarMe::setApiKey("ak_test_JSbrxmahOAw1e4x6LBoh8Mg8EBumLc");
        $t = PagarMe_Transaction::findById("$id_transaction");

        $ultimosDigitos = $t->card_last_digits;
        $nome_cliente = $t->customer['name'];
        $cpf_cli = $t->customer['document_number'];
        $bandeira = $t->card_brand;
        $data_t= $t->data_create;
        $parcelas = $t->installments;

        $arr = explode(" ", $nome_cliente);

        $nome_cli = $arr[0];
        $id = Auth::id();
        $prest = $this->selectTransaction($id_transaction, $id);
        $valor_ini = str_replace(".", "", $prest['valor']);
        $valor = str_replace(",", ".", $valor_ini);

        $valorParcela = VendasController::calcula_prestacao($parcelas, $valor);
        $valor_novo_parcela = number_format($valorParcela, 2, ",", ".");
        $valor_novo = number_format($valor, 2, ",", ".");
        GeradorPDFController::gerar($nome_cli, $prest['name'], $prest['logradouro'], $prest['numero'], $prest['cidade'], $prest['estado'], $prest['cep'], $prest['nome-serv'], $prest['data'], $valor_novo, $bandeira, $ultimosDigitos, $parcelas, $valor_novo_parcela, $nome_cliente, $cpf_cli);

    }

    public function estornar(Request $request){
        $id_transaction = $request['id'];
         //PagarMe::setApiKey("ak_live_QIWpnGHuFK5lx9QOYXyvfBPWKtKMKi");
        PagarMe::setApiKey("ak_test_JSbrxmahOAw1e4x6LBoh8Mg8EBumLc");
        $t = PagarMe_Transaction::findById("$id_transaction");
        $t->refund();
        $this->updateEstorno($id_transaction);

        return "success";
    }

    public function selectTransaction($id_t, $id_u){
        $nome_serv = DB::table('vendas')->where('id_transaction','=', $id_t)->value('nome-serv');
        $valor = DB::table('vendas')->where('id_transaction','=', $id_t)->value('valor');
        $nome_user = DB::table('users')->where('id','=', $id_u)->value('name');
        $log_user = DB::table('users')->where('id','=', $id_u)->value('logradouro');
        $num_user = DB::table('users')->where('id','=', $id_u)->value('numero');
        $cidade_user = DB::table('users')->where('id','=', $id_u)->value('cidade');
        $estado_user = DB::table('users')->where('id','=', $id_u)->value('uf');
        $cep_user = DB::table('users')->where('id','=', $id_u)->value('cep');
        $data_create = DB::table('vendas')->where('id_transaction','=', $id_t)->value('created_at');

        $data = explode(" ", $data_create);
        $data1 = explode("-", $data[0]);
        $nova_data = $data1[2]."/".$data1[1]."/".$data1[0];

        $arr = array("nome-serv" => $nome_serv, "valor" => $valor, "name" => $nome_user, "logradouro" => $log_user, "numero" => $num_user, "cidade" => $cidade_user, "estado" => $estado_user, "cep" => $cep_user, "data" => $nova_data);
        return $arr;
    }

    public function updateEstorno($id){
        DB::table('vendas')->where('id_transaction', $id)->update(['estorno' => 'S']);
    }
}
