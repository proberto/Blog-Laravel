<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User;
use PagarMe;
use PagarMe_Recipient;
use PagarMe_Bank_Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Validator;

class ContasController extends Controller
{
      
    public $bancos = array("001" => "BANCO DO BRASIL S/A", 
                            "237" => "BANCO BRADESCO S.A",
                            "341" => "BANCO ITAU S.A",
                            "104" => "CAIXA ECONOMICA FEDERAL",
                            "502" => "BANCO SANTANDER S.A",
                            "002" => "BANCO CENTRAL DO BRASIL",
                            "003" => "BANCO DA AMAZONIA S.A",
                            "004" => "BANCO DO NORDESTE DO BRASIL S.A",
                            "007" => "BANCO NAC DESENV. ECO. SOCIAL S.A",
                            "008" => "BANCO MERIDIONAL DO BRASIL",
                            "012" => "BANCO STANDARD DE INVESTIMENTOS S.A.", 
                            "014" => "NATIXIS BRASIL S.A.", 
                            "019" => "BANCO AZTECA DO BRASIL S.A.", 
                            "020" => "BANCO DO ESTADO DE ALAGOAS S.A",
                            "021" => "BANCO DO ESTADO DO ESPIRITO SANTO S.A",
                            "022" => "BANCO DE CREDITO REAL DE MINAS GERAIS SA",
                            "024" => "BANCO DO ESTADO DE PERNAMBUCO",
                            "025" => "BANCO ALFA S/A",
                            "026" => "BANCO DO ESTADO DO ACRE S.A",
                            "027" => "BANCO DO ESTADO DE SANTA CATARINA S.A",
                            "028" => "BANCO DO ESTADO DA BAHIA S.A",
                            "029" => "BANCO DO ESTADO DO RIO DE JANEIRO S.A",
                            "030" => "BANCO DO ESTADO DA PARAIBA S.A",
                            "031" => "BANCO DO ESTADO DE GOIAS S.A",
                            "032" => "BANCO DO ESTADO DO MATO GROSSO S.A.",
                            "033" => "BANCO DO ESTADO DE SAO PAULO S.A",
                            "034" => "BANCO DO ESADO DO AMAZONAS S.A",
                            "035" => "BANCO DO ESTADO DO CEARA S.A",
                            "036" => "BANCO DO ESTADO DO MARANHAO S.A",
                            "037" => "BANCO DO ESTADO DO PARA S.A",
                            "038" => "BANCO DO ESTADO DO PARANA S.A",
                            "039" => "BANCO DO ESTADO DO PIAUI S.A",
                            "041" => "BANCO DO ESTADO DO RIO GRANDE DO SUL S.A",
                            "047" => "BANCO DO ESTADO DE SERGIPE S.A",
                            "048" => "BANCO DO ESTADO DE MINAS GERAIS S.A",
                            "059" => "BANCO DO ESTADO DE RONDONIA S.A",
                            "070" => "BANCO DE BRASILIA S.A",
                            "106" => "BANCO ITABANCO S.A.",
                            "107" => "BANCO BBM S.A",
                            "109" => "BANCO CREDIBANCO S.A",
                            "116" => "BANCO B.N.L DO BRASIL S.A",
                            "148" => "MULTI BANCO S.A",
                            "151" => "CAIXA ECONOMICA DO ESTADO DE SAO PAULO",
                            "153" => "CAIXA ECONOMICA DO ESTADO DO R.G.SUL",
                            "165" => "BANCO NORCHEM S.A",
                            "166" => "BANCO INTER-ATLANTICO S.A",
                            "168" => "BANCO C.C.F. BRASIL S.A",
                            "175" => "CONTINENTAL BANCO S.A",
                            "184" => "BBA -CREDITANSTALT S.A",
                            "199" => "BANCO FINANCIAL PORTUGUES",
                            "200" => "BANCO FRICRISA AXELRUD S.A",
                            "201" => "BANCO AUGUSTA INDUSTRIA E COMERCIAL S.A",
                            "204" => "BANCO S.R.L S.A",
                            "205" => "BANCO SUL AMERICA S.A",
                            "206" => "BANCO MARTINELLI S.A",
                            "208" => "BANCO PACTUAL S.A",
                            "210" => "DEUTSCH SUDAMERIKANICHE BANK AG",
                            "211" => "BANCO SISTEMA S.A",
                            "212" => "BANCO MATONE S.A",
                            "213" => "BANCO ARBI S.A",
                            "214" => "BANCO DIBENS S.A",
                            "215" => "BANCO AMERICA DO SUL S.A",
                            "216" => "BANCO REGIONAL MALCON S.A",
                            "217" => "BANCO AGROINVEST S.A",
                            "218" => "BBS -BANCO BONSUCESSO S.A.",
                            "219" => "BANCO DE CREDITO DE SAO PAULO S.A",
                            "220" => "BANCO CREFISUL",
                            "221" => "BANCO GRAPHUS S.A",
                            "222" => "BANCO AGF BRASIL S. A.",
                            "223" => "BANCO INTERUNION S.A",
                            "224" => "BANCO FIBRA S.A",
                            "225" => "BANCO BRASCAN S.A",
                            "228" => "BANCO ICATU S.A",
                            "229" => "BANCO CRUZEIRO S.A",
                            "230" => "BANCO BANDEIRANTES S.A",
                            "231" => "BANCO BOAVISTA S.A",
                            "232" => "BANCO INTERPART S.A",
                            "233" => "BANCO MAPPIN S.A",
                            "234" => "BANCO LAVRA S.A.",
                            "235" => "BANCO LIBERAL S.A",
                            "236" => "BANCO CAMBIAL S.A",
                            "239" => "BANCO BANCRED S.A",
                            "240" => "BANCO DE CREDITO REAL DE MINAS GERAIS S.",
                            "241" => "BANCO CLASSICO S.A",
                            "242" => "BANCO EUROINVEST S.A",
                            "243" => "BANCO STOCK S.A",
                            "244" => "BANCO CIDADE S.A",
                            "245" => "BANCO EMPRESARIAL S.A",
                            "246" => "BANCO ABC ROMA S.A",
                            "247" => "BANCO OMEGA S.A",
                            "249" => "BANCO INVESTCRED S.A",
                            "250" => "BANCO SCHAHIN CURY S.A",
                            "251" => "BANCO SAO JORGE S.A.",
                            "252" => "BANCO FININVEST S.A",
                            "254" => "BANCO PARANA BANCO S.A",
                            "255" => "MILBANCO S.A.",
                            "256" => "BANCO GULVINVEST S.A",
                            "258" => "BANCO INDUSCRED S.A",
                            "261" => "BANCO VARIG S.A",
                            "262" => "BANCO BOREAL S.A",
                            "263" => "BANCO CACIQUE",
                            "264" => "BANCO PERFORMANCE S.A",
                            "265" => "BANCO FATOR S.A",
                            "266" => "BANCO CEDULA S.A",
                            "267" => "BANCO BBM-COM.C.IMOB.CFI S.A.",
                            "275" => "BANCO REAL S.A",
                            "277" => "BANCO PLANIBANC S.A",
                            "282" => "BANCO BRASILEIRO COMERCIAL",
                            "291" => "BANCO DE CREDITO NACIONAL S.A",
                            "294" => "BCR -BANCO DE CREDITO REAL S.A",
                            "295" => "BANCO CREDIPLAN S.A",
                            "300" => "BANCO DE LA NACION ARGENTINA S.A",
                            "302" => "BANCO DO PROGRESSO S.A",
                            "303" => "BANCO HNF S.A.",
                            "304" => "BANCO PONTUAL S.A",
                            "308" => "BANCO COMERCIAL BANCESA S.A.",
                            "318" => "BANCO B.M.G. S.A",
                            "320" => "BANCO INDUSTRIAL E COMERCIAL",
                            "346" => "BANCO FRANCES E BRASILEIRO S.A",
                            "347" => "BANCO SUDAMERIS BRASIL S.A",
                            "351" => "BANCO BOZANO SIMONSEN S.A",
                            "353" => "BANCO GERAL DO COMERCIO S.A",
                            "356" => "ABN AMRO S.A",
                            "366" => "BANCO SOGERAL S.A",
                            "369" => "PONTUAL",
                            "370" => "BEAL -BANCO EUROPEU PARA AMERICA LATINA",
                            "372" => "BANCO ITAMARATI S.A",
                            "375" => "BANCO FENICIA S.A",
                            "376" => "CHASE MANHATTAN BANK S.A",
                            "388" => "BANCO MERCANTIL DE DESCONTOS S/A",
                            "389" => "BANCO MERCANTIL DO BRASIL S.A",
                            "392" => "BANCO MERCANTIL DE SAO PAULO S.A",
                            "394" => "BANCO B.M.C. S.A",
                            "399" => "BANCO BAMERINDUS DO BRASIL S.A",
                            "409" => "UNIBANCO -UNIAO DOS BANCOS BRASILEIROS",
                            "412" => "BANCO NACIONAL DA BAHIA S.A",
                            "415" => "BANCO NACIONAL S.A",
                            "420" => "BANCO NACIONAL DO NORTE S.A",
                            "422" => "BANCO SAFRA S.A",
                            "424" => "BANCO NOROESTE S.A",
                            "434" => "BANCO FORTALEZA S.A",
                            "453" => "BANCO RURAL S.A",
                            "456" => "BANCO TOKIO S.A",
                            "464" => "BANCO SUMITOMO BRASILEIRO S.A",
                            "466" => "BANCO MITSUBISHI BRASILEIRO S.A",
                            "472" => "LLOYDS BANK PLC",
                            "473" => "BANCO FINANCIAL PORTUGUES S.A",
                            "477" => "CITIBANK N.A",
                            "479" => "BANCO DE BOSTON S.A",
                            "480" => "BANCO PORTUGUES DO ATLANTICO-BRASIL S.A",
                            "483" => "BANCO AGRIMISA S.A.",
                            "487" => "DEUTSCHE BANK S.A -BANCO ALEMAO",
                            "488" => "BANCO J. P. MORGAN S.A",
                            "489" => "BANESTO BANCO URUGAUAY S.A",
                            "492" => "INTERNATIONALE NEDERLANDEN BANK N.V.",
                            "493" => "BANCO UNION S.A.C.A",
                            "494" => "BANCO LA REP. ORIENTAL DEL URUGUAY",
                            "495" => "BANCO LA PROVINCIA DE BUENOS AIRES",
                            "496" => "BANCO EXTERIOR DE ESPANA S.A",
                            "498" => "CENTRO HISPANO BANCO",
                            "499" => "BANCO IOCHPE S.A",
                            "501" => "BANCO BRASILEIRO IRAQUIANO S.A.",
                            "504" => "BANCO MULTIPLIC S.A",
                            "505" => "BANCO GARANTIA S.A",
                            "600" => "BANCO LUSO BRASILEIRO S.A",
                            "601" => "BFC BANCO S.A.",
                            "602" => "BANCO PATENTE S.A",
                            "604" => "BANCO INDUSTRIAL DO BRASIL S.A",
                            "607" => "BANCO SANTOS NEVES S.A",
                            "608" => "BANCO OPEN S.A",
                            "610" => "BANCO V.R. S.A",
                            "611" => "BANCO PAULISTA S.A",
                            "612" => "BANCO GUANABARA S.A",
                            "613" => "BANCO PECUNIA S.A",
                            "616" => "BANCO INTERPACIFICO S.A",
                            "617" => "BANCO INVESTOR S.A.",
                            "618" => "BANCO TENDENCIA S.A",
                            "621" => "BANCO APLICAP S.A.",
                            "622" => "BANCO DRACMA S.A",
                            "623" => "BANCO PANAMERICANO S.A",
                            "624" => "BANCO GENERAL MOTORS S.A",
                            "625" => "BANCO ARAUCARIA S.A",
                            "626" => "BANCO FICSA S.A",
                            "627" => "BANCO DESTAK S.A",
                            "628" => "BANCO CRITERIUM S.A",
                            "629" => "BANCORP BANCO COML. E. DE INVESTMENTO",
                            "630" => "BANCO INTERCAP S.A",
                            "633" => "BANCO REDIMENTO S.A",
                            "634" => "BANCO TRIANGULO S.A",
                            "635" => "BANCO DO ESTADO DO AMAPA S.A",
                            "637" => "BANCO SOFISA S.A",
                            "638" => "BANCO PROSPER S.A",
                            "639" => "BIG S.A. -BANCO IRMAOS GUIMARAES",
                            "640" => "BANCO DE CREDITO METROPOLITANO S.A",
                            "641" => "BANCO EXCEL ECONOMICO S/A",
                            "643" => "BANCO SEGMENTO S.A",
                            "645" => "BANCO DO ESTADO DE RORAIMA S.A",
                            "647" => "BANCO MARKA S.A",
                            "648" => "BANCO ATLANTIS S.A",
                            "649" => "BANCO DIMENSAO S.A",
                            "650" => "BANCO PEBB S.A",
                            "652" => "BANCO FRANCES E BRASILEIRO SA",
                            "653" => "BANCO INDUSVAL S.A",
                            "654" => "BANCO A. J. RENNER S.A",
                            "655" => "BANCO VOTORANTIM S.A.",
                            "656" => "BANCO MATRIX S.A",
                            "657" => "BANCO TECNICORP S.A",
                            "658" => "BANCO PORTO REAL S.A",
                            "702" => "BANCO SANTOS S.A",
                            "705" => "BANCO INVESTCORP S.A.",
                            "707" => "BANCO DAYCOVAL S.A",
                            "711" => "BANCO VETOR S.A.",
                            "713" => "BANCO CINDAM S.A",
                            "715" => "BANCO VEGA S.A",
                            "718" => "BANCO OPERADOR S.A",
                            "719" => "BANCO PRIMUS S.A",
                            "720" => "BANCO MAXINVEST S.A",
                            "721" => "BANCO CREDIBEL S.A",
                            "722" => "BANCO INTERIOR DE SAO PAULO S.A",
                            "724" => "BANCO PORTO SEGURO S.A",
                            "725" => "BANCO FINABANCO S.A",
                            "726" => "BANCO UNIVERSAL S.A",
                            "728" => "BANCO FITAL S.A",
                            "729" => "BANCO FONTE S.A",
                            "730" => "BANCO COMERCIAL PARAGUAYO S.A",
                            "731" => "BANCO GNPP S.A.",
                            "732" => "BANCO PREMIER S.A.",
                            "733" => "BANCO NACOES S.A.",
                            "734" => "BANCO GERDAU S.A",
                            "735" => "BACO POTENCIAL",
                            "736" => "BANCO UNITED S.A",
                            "737" => "THECA",
                            "738" => "MARADA",
                            "739" => "BGN",
                            "740" => "BCN BARCLAYS",
                            "741" => "BRP",
                            "742" => "EQUATORIAL",
                            "743" => "BANCO EMBLEMA S.A",
                            "744" => "THE FIRST NATIONAL BANK OF BOSTON",
                            "745" => "CITIBAN N.A.",
                            "746" => "MODAL S\A",
                            "747" => "RAIBOBANK DO BRASIL",
                            "748" => "SICREDI",
                            "749" => "BRMSANTIL SA",
                            "750" => "BANCO REPUBLIC NATIONAL OF NEW YORK (BRA",
                            "751" => "DRESDNER BANK LATEINAMERIKA-BRASIL S/A",
                            "752" => "BANCO BANQUE NATIONALE DE PARIS BRASIL S",
                            "753" => "BANCO COMERCIAL URUGUAI S.A.",
                            "755" => "BANCO MERRILL LYNCH S.A",
                            "756" => "BANCO COOPERATIVO DO BRASIL S.A.",
                            "757" => "BANCO KEB DO BRASIL S.A.");

    public function index()
    {
        
        
        $id= Auth::id();

        $first_access= User::where('id','=', $id)->value('first-access');        

        return view('conta')->with('first', $first_access)->with('bancos', $this->bancos)->with('oldData', $this->getOldData($id));                             
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    protected function validator(array $data)
    {   
        $messages = [
            'required' => '*Campo obrigatório',           
        ];
        

        return Validator::make($data, [
            'banco' => 'required',
            'ag' => 'required',
            'conta' => 'required',
            'dv' => 'required',
            'nometitular' => 'required|max:30', 
            'cpfcnpj' => 'required',
            'radioantecipacao' => 'required'            
        ], $messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $this->validator($request->all())->validate();

        $input = $request->all();

        
        if ($input['radiorecebimento'] == "daily") {
            $input['transfer_day'] = 0;
        }
        
         //PagarMe::setApiKey("ak_live_QIWpnGHuFK5lx9QOYXyvfBPWKtKMKi");
        PagarMe::setApiKey("ak_test_JSbrxmahOAw1e4x6LBoh8Mg8EBumLc");

        $account = new PagarMe_Bank_Account(array(
            "bank_code" => "$input[banco]",
            "agencia" => "$input[ag]",
            "agencia_dv" => "0",
            "conta" => "$input[conta]",
            "conta_dv" => "$input[dv]",
            "document_number" => "$input[cpfcnpj]",
            "legal_name" => "$input[nometitular]"
        ));
        $account->create();
    
        $recipient = new PagarMe_Recipient(array(
            "transfer_interval" => "$input[radiorecebimento]",
            "transfer_day" => "$input[transfer_day]",
            "transfer_enabled" => true,
            "automatic_anticipation_enabled" => "$input[radioantecipacao]",
            "anticipatable_volume_percentage" => 100,
            "bank_account_id" => $account->id
        ));
        $recipient->create();
        
        $id = Auth::id();
        $input['recebedor_id'] = $recipient->id;
        $input['user_id'] = $id;
        Conta::create($input);
        
        $id= Auth::id();

        $first_access= User::where('id','=', $id)->value('first-access');

        return view('home')->with('first', $first_access);
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
       $input = $request->all();
       DB::table('contas')->where('user_id', '=', $id)
           ->update(["banco" => $input["banco"], "ag" => $input["ag"], "conta" => $input["conta"], "dv" => $input["dv"], "nometitular" => $input["nometitular"], "cpfcnpj" => $input["cpfcnpj"], "radioantecipacao" => $input["radioantecipacao"], "radiorecebimento" => $input["radiorecebimento"], "transfer_day" => $input["transfer_day"] ]);
       
       /*$result = Conta::find($id);

        $result->banco = $input["banco"];
        $result->ag = $input["ag"];
        $result->conta = $input["conta"];
        $result->dv = $input["dv"];
        $result->nometitular = $input["nometitular"];
        $result->cpfcnpj = $input["cpfcnpj"];
        $result->radioantecipacao = $input["radioantecipacao"];
        $result->radiorecebimento = $input["radiorecebimento"];
        $result->transfer_day = $input["transfer_day"];
        
        $result->save(); */

        /*Redireciona pra home depois que editar a conta*/
        //$id= Auth::id();
        return redirect()->route('home');            
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
    
    public static function select($id){
         //$resultado = Conta::where('user_id', '=', $id)->get();
         $resultado = DB::table('contas')->where('user_id', '=', $id)->value('recebedor_id');
         return $resultado;
         
    }

    public function getOldData($id){
       $result = DB::table('contas')->where('user_id', '=', $id)->get();
       $conta = array();
       
      if($result->isEmpty()){      
              
              $conta["id"] = "";
              $conta["banco"] = "";
              $conta["ag"] = "";
              $conta["conta"] = "";
              $conta["dv"] = "";
              $conta["nometitular"] = "";
              $conta["cpfcnpj"] = "";
              $conta["radioantecipacao"] = "";
              $conta["radiorecebimento"] = "";
              $conta["transfer_day"] = "";      
       }
       
       else{
           
       foreach ($result as $value){
              $conta["id"] = $value->user_id;
              $conta["banco"] = $value->banco;
              $conta["ag"] = $value->ag;
              $conta["conta"] = $value->conta;
              $conta["dv"] = $value->dv;
              $conta["nometitular"] = $value->nometitular;
              $conta["cpfcnpj"] = $value->cpfcnpj;
              $conta["radioantecipacao"] = $value->radioantecipacao;
              $conta["radiorecebimento"] = $value->radiorecebimento;
              $conta["transfer_day"] = $value->transfer_day;           
       }        
    }
    
    return $conta;
  }
       
       
}


