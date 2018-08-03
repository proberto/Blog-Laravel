@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $( "#name" ).focusin(function() {
                $("#help-msg").text(" Digite o nome completo ou razão social da empresa que irá cadastrar.");
            });

            $( "#cnpj-cpf" ).focusin(function() {
                $("#help-msg").text("Agora insira o seu CNPJ para validar usuário.");
            });

            $( "#cep" ).focusin(function() {
                $("#help-msg").text("Insira o CEP do seu estabelecimento.");
            });

            $('#cep').mask('00000-000');

            $('#ddd').mask('(00)');

            var FoneBehavior = function (val) {
              return val.replace(/\D/g, '').length === 9 ? '00000-0000' : '0000-00009';
            },
            spOptions = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(FoneBehavior.apply({}, arguments), options);
                }
            };

            var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

            $('#fone').mask(FoneBehavior, spOptions);
            $('#whats').mask(SPMaskBehavior, spOptions);

            $("#name").attr("placeholder", "*Razão Social");
            $("#cnpj-cpf").attr("placeholder", "*CNPJ");
            $("#cnpj-cpf").mask("99.999.999/9999-99");

            $('input:radio[name="radio-fis-jur"]').change(
                function(){
                    if ($(this).is(':checked') && $(this).val() == 'fisica')
                    {
                        $("#name").attr("placeholder", "*Nome Completo");
                        $("#cnpj-cpf").attr("placeholder", "*CPF");
                        $("#cnpj-cpf").mask("999.999.999-99");
                    }
            });
        });
    </script>
@endsection

<div style="margin-bottom: 4%;"></div>

@section('content')
    <div class="content">
        @include('layouts.partials.center-logo')

        <div class="row vertical-align" style="text-align: center;">
            <div class="col-md-6" style="margin-left: 5%;margin-top: 5%;">
                <div class="row">
                    <!-- bonequinho -->
                    <img src="img/bk-boy.png" >
                </div>

                <div class="row" style="margin-bottom: 25%;">
                    <!-- texto de ajuda -->
                    <h1 class= "custom-h1" id="help-msg">Por favor, cadastre o seu estabelecimento para começar a utilizar o sistema</h1>
                </div>
            </div>

            <div class="col-md-6">
                <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
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

                            <div class="form-group">
                                <input class="form-control custom-form" type="text" name="name" id="name" >
                            </div>
                            <div class="form-group">
                                <input class="form-control custom-form" type="text" name="cnpj-cpf" id="cnpj-cpf" placeholder="*CNPJ">
                            </div>
                            <div class="row">
                                <div class="col-md-4 padding-r">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="cep" id="cep" placeholder="*CEP">
                                    </div>
                                </div>
                                <div class="col-md-8 padding-l">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="logradouro" id="logradouro" placeholder="*Logradouro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 padding-r">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="cidade" id="cidade" placeholder="*Cidade">
                                    </div>
                                </div>
                                <div class="col-md-2 padding-l">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="uf" id="uf" placeholder="*UF">
                                    </div>
                                </div>
                                <div class="col-md-2 padding-r">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="numero" id="numero" placeholder="N&deg;">
                                    </div>
                                </div>
                                <div class="col-md-4 padding-l">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="complemento" id="complemento" placeholder="Complemento">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 padding-r">
                                   <input class="form-control custom-form" type="text" name="ddd" id="ddd" placeholder="DDD">
                                </div>
                                <div class="col-md-4 padding-l">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="fone" id="fone" placeholder="*Telefone">
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
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="email" id="email" placeholder="*E-mail">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="text" name="conf-email" id="conf-email" placeholder="*Confirmar E-mail">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="password" name="password" id="password" placeholder="*Senha">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control custom-form" type="password" name="conf-senha" id="conf-senha" placeholder="*Confirmar Senha">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button id="solicitar-cadastro-btn" type="button" class="btn btn-green btn-block" data-toggle="modal" data-target="#myModal">Solicitar Cadastro</button>
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
                            Obrigado por escolher a BLUKAN
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
