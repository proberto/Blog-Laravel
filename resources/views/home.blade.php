@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $( "#nome-serv" ).focusin(function() {
                $("#help-msg").text("Você pode atribuir um nome para cada serviço vendido");
            });

            $( "#valor" ).focusin(function() {
                $("#help-msg").text("Insira o valor da venda");
            });

            $( "#parcelas" ).focusin(function() {
                $("#help-msg").text("Defina a quantidade de parcelas que o seu cliente deseja pagar");
            });

            $( "#n-card" ).focusin(function() {
                $("#help-msg").text("Digite o número do cartão do cliente (XXXX XXXX XXXX XXXX)");
            });

            $( "#mes" ).focusin(function() {
                $("#help-msg").text("Insira o mês da validade do cartão");
            });

            $( "#ano" ).focusin(function() {
                $("#help-msg").text("Insira o ano da validade do cartão");
            });

            $( "#cvv" ).focusin(function() {
                $("#help-msg").text("Insira o código de segurança que consta no cartão (ele tem 3 ou 4 dígitos)");
            });

            $( "#name" ).focusin(function() {
                $("#help-msg").text("Insira o nome do cliente assim como está escrito no cartão");
            });

            $( "#nome" ).focusin(function() {
                $("#help-msg").text("Insira o nome completo do cliente");
            });

            $( "#cpf" ).focusin(function() {
                $("#help-msg").text("Insira o CPF do cliente");
            });

            $( "#email" ).focusin(function() {
                $("#help-msg").text("Insira o E-mail do cliente");
            });

            $( "#cep" ).focusin(function() {
                $("#help-msg").text("Insira o CEP do cliente");
            });

            $( "#logadouro" ).focusin(function() {
                $("#help-msg").text("Se não localizamos pelo CEP, insira o endereço do cliente");
            });

            $( "#numero" ).focusin(function() {
                $("#help-msg").text("Insira o número do cliente");
            });

            $( "#bairro" ).focusin(function() {
                $("#help-msg").text("Insira o bairro do cliente");
            });

            $( "#cidade" ).focusin(function() {
                $("#help-msg").text("Insira a cidade do cliente");
            });

            $( "#uf" ).focusin(function() {
                $("#help-msg").text("Selecione o estado do cliente");
            });

            $( "#ddd" ).focusin(function() {
                $("#help-msg").text("Insira o DDD");
            });

            $( "#fone" ).focusin(function() {
                $("#help-msg").text("Insira número de telefone sem o DDD");
            });

            $( "#fone" ).focusout(function() {
                $("#help-msg").text("Por favor, preencha os campos ao lado para efetuar uma venda");
            });

            $('#cep').mask('00000-000');
            $('#cpf').mask('000.000.000-00');
            $('#valor').mask('000.000.000.000.000,00', {reverse: true});
            $('#n-card').mask('0000 0000 0000 0000');
            $('#ddd').mask('00');

            var first = $('#first-access').data("acesso");

            if(first == 1){
                $('#modal-assitente').modal('show');
            }
            /*$("#enviar-pag-button").click(function(){
                 $('#modal-pagamento').modal('show');
            });*/

            var FoneBehavior = function (val) {
              return val.replace(/\D/g, '').length === 9 ? '00000-0000' : '0000-00009';
            },
            spOptions = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(FoneBehavior.apply({}, arguments), options);
                }
            };

            $('#fone').mask(FoneBehavior, spOptions);

            function parcelas(nParcelas, valor){

                total= valor/nParcelas;

                return total.toFixed(2);

            }

            $('#valor').blur(function(){

                var valorVar = $('#valor').val();

                if(valorVar == ''){
                    valorVar = 0;
                }

                else {
                    valorVar= valorVar.replace(/\./g,'')
                }

                $('#parcelas option:gt(0)').remove();

                for (i = 1; i < 13; i++) {
                    $('#parcelas').append($('<option>', {
                        value: i,
                        text : i + ' X R$' + String(parcelas(i, parseInt(valorVar))).replace(".", ",")
                    }));
                }
            });

            /*$('#cadastrar-conta-modal').on("click",function(){
                $.ajax({
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                    },
                    url: '/setAccessFalse',
                    type: 'get',
                    success: function (data) {
                        window.location='{{ url("/conta") }}';
                    }
                });
            });*/

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#logadouro").val("carregando...");
                        $("#bairro").val("carregando...");
                        $("#cidade").val("carregando...");
                        $("#uf").val("carregando...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logadouro").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });

            $('#enviar-pag-button').on("click",function(){

                /*
                 **
                 *Data to confirmation modal
                */
                var serv = $('#nome-serv').val();
                var valor= $('#valor').val();
                var parcelas= $('#parcelas').val();
                var n_card= $('#n-card').val();
                var mes= $('#mes').val();
                var ano= $('#ano').val();
                var cvv= $('#cvv').val();
                var name= $('#name').val();
                var nome= $('#nome').val();
                var cpf= $('#cpf').val();
                var email= $('#email').val();
                var cep= $('#cep').val();
                var logadouro= $('#logadouro').val();
                var numero= $('#numero').val();
                var bairro= $('#bairro').val();
                var cidade= $('#cidade').val();
                var uf= $('#uf').val();
                var ddd= $('#ddd').val();
                var fone= $('#fone').val();

                $('#modal-conf-body').html("<b>Informações do Serviço</b><br>"+ serv +"<br>R$"+valor+"<br>"+parcelas+" parcelas<br><br><b>Informações do Pagamento</b><br>"+ n_card +"<br>Mês: "+mes+"<br>Ano: "+ano+"<br>CVV: "+cvv+"<br>"+name+"<br><br><b>Informações do Cliente</b><br>"+nome+"<br>"+cpf+"<br>"+email+"<br>"+cep+"<br>"+logadouro+", "+numero+"<br>"+bairro+"<br>"+cidade+"-"+uf+"<br>"+"("+ddd+")"+fone);
            });

            /*$("#vendas-form").submit(function () {
              $("#confirma-venda-btn").text('Enviando...');
                if ($(this).valid()) {
                    $(this).submit(function () {
                        return false;
                    });
                    return true;
                }
                else {
                    return false;
                }
            });*/

            $("#vendas-form").submit(function () {
                //$("#confirma-venda-btn").text('Enviando...');
                //$("#edita-venda-btn").prop('disabled', true);

                $(this).submit(function() {
                    return false;
                });

                return true;
            });
        });
    </script>
@endsection

@section('content')
    @include('layouts.partials.navbar-top')

    <div class="content">
        @include('layouts.partials.center-logo')

        @include('layouts.partials.help-modal')

        @include('layouts.conf-payment-modal')

        <!--<div id="first-access" data-acesso="{{ $first or 0 }}"></div>-->

        <div class="row vertical-align" style="text-align: center;">
            <div class="col-md-6" style="margin-left: 5%;">
                <div class="row">
                    <!-- bonequinho -->
                    <img src="img/bk-boy.png" >
                </div>

                <div class="row" style="margin-bottom: 25%;">
                    <!-- texto de ajuda -->
                    <h1 class= "custom-h1" id="help-msg">Por favor, preencha os campos ao lado para efetuar uma venda</h1>
                </div>
            </div>

            <div class="col-md-6">
                <form id= "vendas-form" role="form" method="POST" action="{{ url('/vendas') }}">
                    <div id="confirm" class="modal hide fade">
                        <div class="modal-body">
                            Are you sure?
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div style="text-align: left;"><h3 class="custom-h3">1- Informações do Serviço</h3></div>
                            <div class="form-group{{ $errors->has('nome-serv') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="nome-serv" id="nome-serv" placeholder="Nome do Serviço" value="{{ old('nome-serv') }}">

                                @if ($errors->has('nome-serv'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome-serv') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                                <input  class="form-control custom-form" type="text" name="valor" id="valor" placeholder="Valor" value="{{ old('valor') }}">

                                @if ($errors->has('valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('parcelas') ? ' has-error' : '' }}">
                                <select class="form-control selectpicker custom-form" name="parcelas" id="parcelas" placeholder="Quantidade de Parcelas">
                                    <option value="" disabled selected>Parcelas</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <option value= "{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>

                                @if ($errors->has('parcelas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('parcelas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div style="text-align: left;"><h3 class="custom-h3">2- Informações do Pagamento</h3></div>
                            <div class="form-group{{ $errors->has('n-card') ? ' has-error' : '' }}">
                                <input  class="form-control custom-form" type="text" name="n-card" id="n-card" placeholder="Número do Cartão" value="{{ old('n-card') }}">

                                @if ($errors->has('n-card'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n-card') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('mes') ? ' has-error' : '' }}">
                                        <select class="form-control custom-form" name="mes" id="mes" placeholder="mes">
                                            <option value="" disabled selected>Mês</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option>{{ $i }}</option>
                                            @endfor
                                        </select>

                                        @if ($errors->has('mes'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('mes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('ano') ? ' has-error' : '' }}">
                                        <select class="form-control custom-form" name="ano" id="ano" placeholder="Ano">
                                            <option value="" disabled selected>Ano</option>
                                            @for ($i = 2016; $i < 2050; $i++)
                                                <option>{{ $i }}</option>
                                            @endfor
                                        </select>

                                        @if ($errors->has('ano'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ano') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('cvv') ? ' has-error' : '' }}">
                                        <input class="form-control custom-form" type="text" name="cvv" id="cvv" placeholder="CVV" value="{{ old('cvv') }}">

                                        @if ($errors->has('cvv'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cvv') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nome-cartao') ? ' has-error' : '' }}">
                                <input  class="form-control custom-form" type="text" name="nome-cartao" id="name" placeholder="Nome como Impresso no Cartão" value="{{ old('nome-cartao') }}">

                                @if ($errors->has('nome-cartao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome-cartao') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div style="text-align: left;"><h3 class="custom-h3">3- Informações do Cliente</h3></div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="nome" id="nome" placeholder="Nome Completo" value="{{ old('nome') }}">

                                        @if ($errors->has('nome'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nome') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="cpf" id="cpf" placeholder="CPF" value="{{ old('cpf') }}">

                                        @if ($errors->has('cpf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cpf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input  class="form-control custom-form" type="text" name="email" id="email" placeholder="Email"  value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="cep" id="cep" placeholder="CEP" value="{{ old('cep') }}">

                                        @if ($errors->has('cep'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cep') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group{{ $errors->has('logadouro') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="logadouro" id="logadouro" placeholder="Logradouro" value="{{ old('logadouro') }}">

                                        @if ($errors->has('logadouro'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('logadouro') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="numero" id="numero" placeholder="N&deg;" value="{{ old('numero') }}">

                                        @if ($errors->has('numero'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('numero') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="bairro" id="bairro" placeholder="Bairro" value="{{ old('bairro') }}">

                                        @if ($errors->has('bairro'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('bairro') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5" style="padding-right: 2px;">
                                    <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="cidade" id="cidade" placeholder="Cidade" value="{{ old('cidade') }}">

                                        @if ($errors->has('cidade'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cidade') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding-left: 2px;padding-right: 2px;">
                                    <div class="form-group{{ $errors->has('uf') ? ' has-error' : '' }}">

                                        <select class="form-control custom-form" name="uf" id="uf">
                                            <option value="">UF</option>
                                            <option value="AC">AC</option>
                                            <option value="AL">AL</option>
                                            <option value="AM">AM</option>
                                            <option value="AP">AP</option>
                                            <option value="BA">BA</option>
                                            <option value="CE">CE</option>
                                            <option value="DF">DF</option>
                                            <option value="ES">ES</option>
                                            <option value="GO">GO</option>
                                            <option value="MA">MA</option>
                                            <option value="MG">MG</option>
                                            <option value="MS">MS</option>
                                            <option value="MT">MT</option>
                                            <option value="PA">PA</option>
                                            <option value="PB">PB</option>
                                            <option value="PE">PE</option>
                                            <option value="PI">PI</option>
                                            <option value="PR">PR</option>
                                            <option value="RJ">RJ</option>
                                            <option value="RN">RN</option>
                                            <option value="RS">RS</option>
                                            <option value="RO">RO</option>
                                            <option value="RR">RR</option>
                                            <option value="SC">SC</option>
                                            <option value="SE">SE</option>
                                            <option value="SP">SP</option>
                                            <option value="TO">TO</option>
                                         </select>

                                         @if ($errors->has('uf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('uf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding-right: 2px;">
                                    <div class="form-group{{ $errors->has('ddd') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="ddd" id="ddd" placeholder="DDD" value="{{ old('ddd') }}">

                                        @if ($errors->has('ddd'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ddd') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding-left: 2px;">
                                    <div class="form-group{{ $errors->has('fone') ? ' has-error' : '' }}">
                                        <input  class="form-control custom-form" type="text" name="fone" id="fone" placeholder="Telefone" value="{{ old('fone') }}">

                                        @if ($errors->has('fone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('fone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <!--<div class="form-group{{ $errors->has('banco') ? ' has-error' : '' }}">
                                        <button type="button" class="btn btn-green btn-block">Cancelar</button>
                                    </div>-->
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-green btn-block" id="enviar-pag-button" data-toggle="modal" data-target="#myModal">Enviar Pagamento</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="text-align: left;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Por favor, confirme os dados da venda</h4>
                          </div>
                          <div class="modal-body" id="modal-conf-body" style="text-align: left;">
                          </div>
                          <div class="modal-footer">
                            <button id="edita-venda-btn" type="button" class="btn btn-default" data-dismiss="modal">Editar</button>
                            <!-- This is the submit button of the form -->
                          <button id="confirma-venda-btn" type="submit" class="btn btn-green">Confirmar</button>
                          </div>
                        </div>
                      </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
