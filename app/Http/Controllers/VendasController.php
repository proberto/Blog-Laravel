<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\Conta;
use App\User;
use PagarMe;
use PagarMe_Card;
use PagarMe_Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Validator;

class VendasController extends Controller
{
    //public $acesso= 0;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id= Auth::id();

        $first_access= User::where('id','=', $id)->value('first-access');

        return view('home')->with('first', $first_access);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home');
    }

    protected function validator(array $data)
    {
        $messages = [
            'required' => '*Campo obrigatório',
            'email' => 'Insira um email válido'
        ];


        $validator= Validator::make($data, [
            'nome-serv' => 'required',
            'valor' => 'required',
            'parcelas' => 'required',
            'n-card' => 'required',
            'mes' => 'required',
            'ano' => 'required',
            'cvv' => 'required',
            'nome-cartao' => 'required',
            'nome' => 'required',
            'cpf' => 'required',
            'email' => 'required|email|max:255',
            'cep' => 'required',
            'logadouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'ddd' => 'required',
            'fone' => 'required'
        ], $messages);

        /*if ($validator->fails()) {
            return redirect('vendas')
                        ->withErrors($validator)
                        ->withInput();
        }

        else {
          return $validator;
        }*/

        return $validator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->flash();

        $validator= $this->validator($request->all())->validate();

        $input = $request->all();
        $cpf_ini = str_replace(".", "", $input['cpf']);
        $cpf = str_replace("-", "", $cpf_ini);
        $cep = str_replace("-", "", $input['cep']);
        $valor_ini = str_replace(".", "", $input['valor']);
        $valor = str_replace(",", ".", $valor_ini);
        $fone = str_replace("-","",$input['fone']);
        $ano = substr($input['ano'], 2);

        $p = VendasController::calcula_prestacao($input['parcelas'], $valor);
        $valor_total_final = $p * $input['parcelas'];
        $amount = number_format(($valor_total_final * 100), 0, ".", "");


        if ($input['parcelas'] == '1'){
            $valor_blukan = $valor_total_final * 0.0043;
            $valor_prestador = $valor_total_final * 0.9957;
            $amount_blukan_1 = (round($valor_blukan, 2) * 100) - 26;
            $amount_blukan = number_format(($amount_blukan_1), 0, ".", "");
            $amount_prestador_1 = (round($valor_prestador, 2) * 100) + 26;
            $amount_prestador = number_format(($amount_prestador_1), 0, ".", "");
        }
        elseif (($input['parcelas'] >= '2') && ($input['parcelas'] < '7')) {
            $valor_blukan = $valor_total_final * 0.0067;
            $valor_prestador = $valor_total_final * 0.9933;
            $amount_blukan_1 = (round($valor_blukan, 2) * 100) - 26;
            $amount_blukan = number_format(($amount_blukan_1), 0, ".", "");
            $amount_prestador_1 = (round($valor_prestador, 2) * 100) + 26;
            $amount_prestador = number_format(($amount_prestador_1), 0, ".", "");
        }
        else{
            $valor_blukan = $valor_total_final * 0.0060;
            $valor_prestador = $valor_total_final * 0.9940;
            $amount_blukan_1 = (round($valor_blukan, 2) * 100) - 26;
            $amount_blukan = number_format(($amount_blukan_1), 0, ".", "");
            $amount_prestador_1 = (round($valor_prestador, 2) * 100) + 26;
            $amount_prestador = number_format(($amount_prestador_1), 0, ".", "");
        }

        $id = Auth::id();
        $nome_prest = DB::table('users')->where('id','=', $id)->value('name');
        $recebedor = ContasController::select($id);
        $name1 = substr($nome_prest, 0, 13);
        $name = VendasController::sanitizeString($name1);
       
        
        //PagarMe::setApiKey("ak_live_QIWpnGHuFK5lx9QOYXyvfBPWKtKMKi");
        PagarMe::setApiKey("ak_test_JSbrxmahOAw1e4x6LBoh8Mg8EBumLc");
                             
        $card = new PagarMe_Card(array(
            "card_number" => $input['n-card'],
            "card_holder_name" => $input['nome-cartao'],
            "card_expiration_month" => $input['mes'],
            "card_expiration_year" => $ano,
            "card_cvv" => $input['cvv'],
        ));
        $card->create();

        $transaction = new PagarMe_Transaction(array(
            "amount" => $amount,
            "card_id" => "$card->id",
            "postback_url" => "http://www.blukan.com.br/vendas",
            "installments" => $input['parcelas'],
            "soft_descriptor" => "$name",
            "customer" => array(
                "name" => $input['nome'],
                "document_number" => $cpf,
                "email" => $input['email'],
                "address" => array(
                    "street" => $input['logadouro'],
                    "street_number" => $input['numero'],
                    "neighborhood" => $input['bairro'],
                    "zipcode" => $cep
                ),
                "phone" => array(
                  "ddd" => $input['ddd'],
                  "number" => $fone
                )
            ),
            "split_rules" => array(
                0 => array(
                    "recipient_id" => "$recebedor",
                    "charge_processing_fee" => true,
                    "liable" => true,
                    "percentage" => NULL,
                    "amount" => $amount_prestador
            ), 1 => array(
                    //"recipient_id" => "re_citocniqj043c3z5x826ur0fm", //id live
                    "recipient_id" => "re_civ8duu6r00oedr6exgo07kxx", //id teste
                    "charge_processing_fee" => false,
                    "liable" => false,
                    "percentage" => NULL,
                    "amount" => $amount_blukan))
        ));


        $transaction->charge();

        $save = $request->except(['n-card','nome-cartao','mes','ano','cvv']);
        $save['id_cartao'] = $card->id;
        $save['user_id'] = Auth::id();
        $save['id_transaction'] = $transaction->id;
        $save['valor_total'] = $valor_total_final;
        $save['estorno'] = 'N';

        Venda::create($save);

        return redirect()->route('transacoes');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function calcula_prestacao ($parcela, $valor){
          $juros = 0.03;

          if ($parcela == '1'){
              $p = $valor;
              return $p;
          }
          else{
              $p = $valor / $parcela;

              return $p;
          }
         /* else{
              $p = $valor * ((pow((1 + $juros), $parcela) * $juros)/(pow((1+$juros), $parcela)-1));
              return round($p, 2);
          } */
    }

    /*
    // Retorna um JSON com o valor equivalente de cada parcela com base no valor do serviço
    */

    public function calcula_valor_parcelas (Request $request){
        $arr= array();

        $input= $request->all();
        $valor= $input['valor'];

        for($i = 1; $i < 13 ; $i++){
            $r = VendasController::calcula_prestacao($i, $valor);
            $arr[$i] = $r;
        }

        return response()->json($arr);
    }

    public function firstAcessFalse(){
        $id= Auth::id();

        $first_access= User::where('id','=', $id)->update(['first-access' => 0]);
    }

    public function sanitizeString($string) {

    // matriz de entrada
    $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    // matriz de saída
    $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );

    // devolver a string
    return str_replace($what, $by, $string);
}

}
