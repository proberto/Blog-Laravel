@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modal-assitente').modal('show');

            $('input[type="radio"]').click(function() {
                $("#help-msg").text("Defina se irá cadastrar uma Pessoa Física ou Pessoa Jurídica");                   
            });            
            
            $( "#name" ).focusin(function() {
                if($('input[name=radio-fis-jur]:checked', '#main-form').val() == 'juridica'){
                    $("#help-msg").text("Digite a razão social da empresa que irá cadastrar");
                }

                else if($('input[name=radio-fis-jur]:checked', '#main-form').val() == 'fisica'){
                    $("#help-msg").text("Insira o seu nome completo");    
                }                    
            });

            $( "#cnpj-cpf" ).focusin(function() {
                if($('input[name=radio-fis-jur]:checked', '#main-form').val() == 'juridica'){
                    $("#help-msg").text("Agora digite o CNPJ da empresa que está cadastrando");
                }

                else if($('input[name=radio-fis-jur]:checked', '#main-form').val() == 'fisica'){
                    $("#help-msg").text("Agora digite o seu CPF");    
                }
            });

            $( "#cep" ).focusin(function() {
                $("#help-msg").text("Insira o CEP do seu estabelecimento");    
            });

            $( "#logradouro" ).focusin(function() {
                $("#help-msg").text("Se não localizamos pelo seu CEP, insira o endereço do estabelecimento");    
            });

            $( "#cidade" ).focusin(function() {
                $("#help-msg").text("Insira cidade do estabelecimento");    
            });

            $( "#uf" ).focusin(function() {
                $("#help-msg").text("Insira o estado do estabelecimento");    
            });

            $( "#numero" ).focusin(function() {
                $("#help-msg").text("Insira o número do estabelecimento");    
            });

            $( "#complemento" ).focusin(function() {
                $("#help-msg").text("Insira o complemento do endereço, se houver");    
            });

            $( "#ddd" ).focusin(function() {
                $("#help-msg").text("Insira o DDD do seu telefone");    
            });

            $( "#fone" ).focusin(function() {
                $("#help-msg").text("Insira o número de telefone");    
            });

            $( "#whats" ).focusin(function() {
                $("#help-msg").text(" Insira o número de Whatsapp com DDD, se houver");    
            });

            $( "#email, #email_confirmation" ).focusin(function() {
                $("#help-msg").text("Insira um e-mail válido que irá utilizar para fazer login da sua conta Blukan");    
            });

            $( "#email_confirmation" ).focusin(function() {
                $("#help-msg").text(" Repita o e-mail para confirmar que cadastrou o e-mail corretamente");    
            });

            $("#password").focusin(function() {
                $("#help-msg").text("Insira uma senha segura (com no mínimo 6 caracteres) e guarde para você. Ela será solicitada a cada login");    
            });

            $("#password_confirmation").focusin(function() {
                $("#help-msg").text(" Repita a senha para ter certeza que digitou corretamente");    
            });

            $("#password, #password_confirmation").focusout(function() {
                $("#help-msg").text("Por favor, cadastre o seu estabelecimento para começar a utilizar o sistema");    
            });

            $('#cep').mask('00000-000');

            $('#ddd').mask('(00)');            

            //Numero sem DDD
            var FoneBehavior = function (val) {
              return val.replace(/\D/g, '').length === 9 ? '00000-0000' : '0000-00009';
            },
            spOptions1 = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(FoneBehavior.apply({}, arguments), options);
                }
            };

            //Numero com DDD (whatsApp)
            var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions2 = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

            $('#fone').mask(FoneBehavior, spOptions1);
            $('#whats').mask(SPMaskBehavior, spOptions2);

            
            //Default values
            $("#name").attr("placeholder", "*Razão Social");
            $("#cnpj-cpf").attr("placeholder", "*CNPJ");
            $("#cnpj-cpf").mask("99.999.999/9999-99");

            $('input:radio[name="radio-fis-jur"]').change(
                function(){
                    if ($(this).is(':checked') && $(this).val() == 'juridica') 
                    {
                        $("#name").attr("placeholder", "*Razão Social");
                        $("#cnpj-cpf").attr("placeholder", "*CNPJ");
                        $("#cnpj-cpf").mask("99.999.999/9999-99");
                    }
                    else
                    {
                        $("#name").attr("placeholder", "*Nome Completo");
                        $("#cnpj-cpf").attr("placeholder", "*CPF");
                        $("#cnpj-cpf").mask("999.999.999-99");
                    }                    
            });

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("carregando...");
                $("#bairro").val("carregando...");
                $("#cidade").val("carregando...");
                $("#uf").val("carregando...");
                $("#ibge").val("carregando...");
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

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logradouro").val(dados.logradouro);                           
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

            /*$('#cnpj-cpf').cpfcnpj({
                mask: false,
                validate: 'cpfcnpj',
                event: 'focusout',
                
                ifValid: function (input) { window.alert("valid");input.removeClass("error"); },
                ifInvalid: function (input) { window.alert("INvalid");input.addClass("error"); }
            });*/
        });    
    </script>
@endsection


@section('content')
    @include('layouts.partials.navbar-top-login')

    <div class="content">
        @include('layouts.partials.help-modal-2') 

        @include('layouts.partials.center-logo')      

        <div class="row vertical-align" style="text-align: center;">            
            <div class="col-md-6" style="margin-left: 5%;margin-top: 5%;">
                <div class="row">
                    <!-- bonequinho -->
                    <img src="img/bk-boy.png" >
                </div>

                <div class="row">
                    <!-- texto de ajuda -->
                    <h1 class= "custom-h1" id="help-msg">Por favor, cadastre o seu estabelecimento para começar a utilizar o sistema</h1>
                </div> 
            </div>

            <div class="col-md-6">                
                <form role="form" id="main-form" method="POST" action="{{ url('/register') }}">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div style="text-align: left;"><h3 class="custom-h3">1- Dados do Prestador</h3></div>
                        
                            <div class="row" style="margin-left: 1%;">                                
                                <div class="form-group" style="text-align: left;">                                
                                    <label class="radio-inline control-label custom-label">
                                        <input type="radio" name="radio-fis-jur" id="radio-juridica" value="juridica" checked="checked">Pessoa Jurídica
                                    </label>
                                    <label class="radio-inline control-label custom-label">
                                        <input type="radio" name="radio-fis-jur" id="radio-fisica" value="fisica">Pessoa Física 
                                    </label>          
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">                                      
                                <input class="form-control custom-form" type="text" name="name" id="name">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('cnpj-cpf') ? ' has-error' : '' }}">                                      
                                <input class="form-control custom-form" type="text" name="cnpj-cpf" id="cnpj-cpf">

                                @if ($errors->has('cnpj-cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cnpj-cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">                                
                                <div class="col-md-4 padding-r">
                                    <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="text" name="cep" id="cep" placeholder="*CEP">

                                        @if ($errors->has('cep'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cep') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8 padding-l">
                                    <div class="form-group{{ $errors->has('logradouro') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="text" name="logradouro" id="logradouro" placeholder="*Logradouro">

                                        @if ($errors->has('logradouro'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('logradouro') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-4 padding-r">
                                    <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="text" name="cidade" id="cidade" placeholder="*Cidade">

                                        @if ($errors->has('cidade'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cidade') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2 padding-l">
                                    <div class="form-group{{ $errors->has('uf') ? ' has-error' : '' }}">
                                        <select class="form-control custom-form" name="uf" id="uf">
                                            <option value="">*UF</option>
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
                                        <!--<input class="form-control custom-form" type="text" name="uf" id="uf" placeholder="*UF">-->
                                        @if ($errors->has('uf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('uf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2 padding-r">
                                    <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="text" name="numero" id="numero" placeholder="*N&deg;">

                                        @if ($errors->has('numero'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('numero') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 padding-l">
                                    <div class="form-group">                                      
                                        <input class="form-control custom-form" type="text" name="complemento" id="complemento" placeholder="Complemento">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 padding-r{{ $errors->has('ddd') ? ' has-error' : '' }}">
                                   <input class="form-control custom-form" type="text" name="ddd" id="ddd" placeholder="DDD">

                                    @if ($errors->has('ddd'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ddd') }}</strong>
                                        </span>
                                    @endif 
                                </div>                                
                                <div class="col-md-4 padding-l">
                                    <div class="form-group{{ $errors->has('fone') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="text" name="fone" id="fone" placeholder="*Telefone">

                                        @if ($errors->has('fone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('fone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">                                      
                                        <input class="form-control custom-form" type="text" name="whats" id="whats" placeholder="Whatsapp">
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: left;"><h3 class="custom-h3">2- Dados para Login</h3></div>

                            <div class="row">                                
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="text" name="email" id="email" placeholder="*E-mail">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">                                      
                                        <input class="form-control custom-form" type="text" name="email_confirmation" id="email_confirmation" placeholder="*Confirmar E-mail">
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">                                      
                                        <input class="form-control custom-form" type="password" name="password" id="password" placeholder="*Senha" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">                                      
                                        <input class="form-control custom-form" type="password" name="password_confirmation" id="password_confirmation" placeholder="*Confirmar Senha" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <button type="submit" class="btn btn-green btn-block">Cadastrar</button>  
                            </div>                             
                        </div>
                    </div>                    
                </form>                               
            </div>            
        </div>
    </div>
@endsection