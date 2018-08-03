@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            /*Mudar textos de ajuda*/
            $( "#ag").focusin(function() {
                $("#help-msg").text("Digite o número da sua agência (4 dígitos) sem dígito verificador (XXXX)");
            });

            $( "#conta").focusin(function() {
                $("#help-msg").text("Digite o número da sua conta corrente (XXXXX)");
            });

            $( "#dv").focusin(function() {
                $("#help-msg").text("Digite o dígito verificador da sua conta bancária");
            });

            $( "#nome-titular").focusin(function() {
                $("#help-msg").text("Insira o nome completo ou razão social do titular da conta corrente");
            });

            $( "#cpfcnpj").focusin(function() {
                $("#help-msg").text("Insira CPF ou CNPJ do titular da conta corrente");
            });

            $( "#banco").focusin(function() {
                $("#help-msg").text("Selecione o banco da sua conta corrente");
            });

            /*$( "#radio-no, #radio-sim").focusin(function() {
                $("#help-msg").text("Para sua comodidade, o sistema poderá enviar automaticamente para sua conta corrente todos os seus recebimentos em até 72 horas após serviço prestado");
            });

            $( "#radio-dia").focusin(function() {
                $("#help-msg").text("Você pode definir quando e qual periodicidade quer receber a partir da antecipação automática. Diariamente, será creditado até 72 horas após pagamento");
            });

            $( "#radio-mes").focusin(function() {
                $("#help-msg").text("Você pode definir quando e qual periodicidade quer receber a partir da antecipação automática. Mensalmente, poderá definir o dia do mês que irá receber o crédito");
            });

            $( "#radio-semana").focusin(function() {
                $("#help-msg").text("Você pode definir quando e qual periodicidade quer receber a partir da antecipação automática. Semanalmente, poderá definir o dia da semana que irá ser creditado");
            });*/

            $( "#radio-no, #radio-sim").focusin(function() {
                $("#help-msg").text("Passe o mouse sobre o campo para obter mais informações");
            });

            $( "#radio-dia").focusin(function() {
                $("#help-msg").text("Passe o mouse sobre o campo para obter mais informações");
            });

            $( "#radio-mes").focusin(function() {
                $("#help-msg").text("Passe o mouse sobre o campo para obter mais informações");
            });

            $( "#radio-semana").focusin(function() {
                $("#help-msg").text("Passe o mouse sobre o campo para obter mais informações");
            });

            /* Mascaras*/
            $('#cep').mask('00000-000');
            $('#ag').mask('0000');
            $('#dv').mask('0');

            /*Desabilitar dropdowns
            $("#radio-mes").change(function() {
                $("#select-mes").attr("disabled", false);
                //$("#discountselection").show(); //To Show the dropdown
            });
            $("#No").click(function() {
                $("#discountselection").attr("disabled", true);
                //$("#discountselection").hide();//To hide the dropdown
            });*/

            $("input[name='cpfcnpj']").keydown(function(){
            try {
                $("input[name='cpfcnpj']").unmask();
            } catch (e) {}

            var tamanho = $("input[name='cpfcnpj']").val().length;

            if(tamanho < 11){
                $("input[name='cpfcnpj']").mask("999.999.999-99");
            } else if(tamanho > 11){
                $("input[name='cpfcnpj']").mask("99.999.999/9999-99");
            }
            });


           $('input[type="radio"]').click(function() {
               if($(this).attr('id') == 'radio-dia'){
                    $('#select-dia').hide();
                    $('#select-mes').hide();
               }

               else if($(this).attr('id') == 'radio-mes') {
                    $('#select-dia').hide();
                    $('#select-mes').show();
               }

               else if($(this).attr('id') == 'radio-semana'){
                    $('#select-mes').hide();
                    $('#select-dia').show();
               }
           });


            /*$('input:radio[name="radio-recebimento"]').change(
            function(){
                if ($(this).val() == 'Mensalmente') {
                    $('#select-mes').show();
                }
                else if($(this).val() == 'Semanalmente'){
                    $('#select-dia').show();
                }
            });*/

            $('#popover-ajuda1').popover({ trigger: "hover" });
            $('#popover-ajuda2').popover({ trigger: "hover" });

            $('#cadastrar-conta-modal').on("click",function(){
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
            });

            var first = $('#first-access').data("acesso");

            if(first == 1){
                $('#modal-assitente').modal('show');
            }
        });
    </script>
@endsection

@section('content')
    @include('layouts.partials.navbar-top')

    <div class="content">
        @include('layouts.partials.help-modal-2')

        @include('layouts.partials.center-logo')

        <!--<div id="first-access" data-acesso="{{ $first or 1 }}"></div>-->

        <div class="row vertical-align" style="text-align: center;">
            <div class="col-md-6" style="margin-left: 5%;margin-top: 5%; display: block;">
                <div class="row">
                    <!-- bonequinho -->
                    <img src="img/bk-boy.png" >
                </div>

                <div class="row" style="margin-bottom: 25%;">
                    <!-- texto de ajuda -->
                    <h1 class= "custom-h1" id="help-msg">Por favor, cadastre uma conta bancária para receber os pagamentos</h1>
                </div>
            </div>

            <div class="col-md-6">

            @if($oldData['banco'] == '')
                <form role="form" method="POST" action="{{ url('/conta') }}">
            @else
                <form role="form" method="POST" action="{{ url('/conta/' . $oldData['id']) }}">
                {{ method_field('PATCH') }}
            @endif

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                        <div style="text-align: left;"><h3 class="custom-h3">1- Dados do Recebedor</h3></div>

                            <div class="form-group{{ $errors->has('banco') ? ' has-error' : '' }}">
                                <select class="form-control custom-form" id="banco" name="banco" placeholder="Selecione o Banco">
                                    <option value="">Selecione o Banco</option>

                                    @foreach($bancos as $key => $value)
                                        @if( $oldData['banco'] ==  $key)
                                            <option value="{{ $key }}" selected>{{ $key }} - {{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $key }} - {{ $value }}</option>
                                        @endif
                                    @endforeach

                                </select>

                                @if ($errors->has('banco'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banco') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!---<div class="form-group">
                                <input class="form-control custom-form" type="text" name="nome-prestador" id="nome-serv" placeholder="*Nome do Prestador">
                            </div>-->
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('ag') ? ' has-error' : '' }}">

                                        <input class="form-control custom-form" type="text" name="ag" id="ag" placeholder="Agência" value="{{ $oldData['ag'] }}">

                                        @if ($errors->has('ag'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ag') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5" style="padding-right: 2px;">
                                    <div class="form-group{{ $errors->has('conta') ? ' has-error' : '' }}">
                                        <input class="form-control custom-form" type="text" name="conta" id="conta" placeholder="Conta" value="{{ $oldData['conta'] }}">

                                        @if ($errors->has('conta'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('conta') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!--<div class="col-md-1" style="padding-right: 0px;padding-left: 0px;margin-right: 0px;margin-left: 0px;">
                                    <div class="form-group">
                                        <p class="form-control-static" style="padding-right: 0px;padding-left: 0px;margin-right: 0px;margin-left: 0px;"><b>-</b></p>
                                    </div>
                                </div>-->
                                <div class="col-md-2" style="padding-left: 2px;">
                                    <div class="form-group{{ $errors->has('conta') ? ' has-error' : '' }}">
                                        <input class="form-control custom-form" type="text" name="dv" id="dv" placeholder="Dv" value="{{ $oldData['dv'] }}">

                                        @if ($errors->has('dv'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('dv') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nometitular') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="nometitular" id="nome-titular" placeholder="Nome do Titular" value="{{ $oldData['nometitular'] }}">

                                @if ($errors->has('nometitular'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nometitular') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('cpfcnpj') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="cpfcnpj" id="cpfcnpj" placeholder="CPF/CNPJ" value="{{ $oldData['cpfcnpj'] }}">

                                @if ($errors->has('cpfcnpj'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cpfcnpj') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div style="text-align: left;"><h3 class="custom-h3">2- Informações para o recebimento</h3></div>

                            <div class="form-group form-control custom-form-conta" style="text-align: left;" aria-hidden="true" id="popover-ajuda1" data-content="Para sua comodidade, o sistema poderá antecipar automaticamente em até 72 horas todos os seus recebimentos. Ou seja, aquela venda realizada hoje que só seria creditada no mês que vem, poderá ser antecipada para você. Tem custo? Sim, Será cobrada uma taxa de 3% sobre o valor antecipado." rel="popover" data-placement="left" data-original-title="Antecipação Automática">

                            <span class="glyphicon glyphicon-question-sign"></span>

                                <!--<span class="glyphicon glyphicon-question-sign" aria-hidden="true" id="popover-ajuda1" data-content="Para sua comodidade, o sistema poderá antecipar automaticamente em até 72 horas todos os seus recebimentos. Ou seja, aquela venda realizada hoje que só seria creditada no mês que vem, poderá ser antecipada para você. Tem custo? Sim, Será cobrada uma taxa de 3% sobre o valor antecipado." rel="popover" data-placement="left" data-original-title="Antecipação Automática"></span>-->

                                <label class="radio-inline control-label custom-label" style="color: #FFF;padding-left: 4px;">Antecipação Automática
                                </label>
                                <label class="radio-inline control-label custom-label">
                                    <input type="radio" name="radioantecipacao" id="radio-sim" value="true">Sim
                                </label>
                                <label class="radio-inline control-label custom-label">
                                    <input type="radio" name="radioantecipacao" id="radio-no" value="false" checked="checked">Não
                                </label>
                            </div>

                            <div class="form-group back-recebimento custom-form-conta" style="text-align: left;width: auto;" data-html="true" aria-hidden="true" id="popover-ajuda2" data-content="Você pode escolher quando quer receber seu pagamento. <br><br> <b>Diariamente:</b> em até 72 horas, todas as suas vendas a prazo serão creditadas em conta corrente. <br><br> <b>Semanalmente:</b> a cada semana fechada, será gerado crédito das vendas em conta corrente no dia que você determinar. <br><br> <b>Mensalmente:</b> todas as vendas do mês fechado serão creditadas no mês seguinte na data de sua escolha." rel="popover" data-placement="left" data-original-title="Data Recebimento">

                                <span class="glyphicon glyphicon-question-sign popover-ajuda"></span>

                                <label class="radio-inline control-label custom-label" style="color: #FFF;padding-left: 4px;">Data de Recebimento</label>
                                <label class="radio-inline control-label custom-label-sm" style="padding-right: 20px;">
                                    <input type="radio" name="radiorecebimento" id="radio-dia" value="daily" checked="checked">Diariamente
                                </label>
                                <label class="radio-inline control-label custom-label-sm" style="padding-right: 20px;">
                                    <input type="radio" name="radiorecebimento" id="radio-mes" value="monthly" >Mensalmente
                                </label>
                                <label class="radio-inline control-label custom-label-sm">
                                    <input type="radio" name="radiorecebimento" id="radio-semana" value="weekly">Semanalmente
                                </label>

                                <!--<select class="custom-form-sm" id="select-mes" style="display: inline; margin-left: 48%;">
                                    @for ($i = 1; $i < 31; $i++)
                                        <option>Dia {{ $i }}</option>
                                    @endfor
                                </select>

                                <select class="custom-form-sm" id="select-dia" style="display: inline; margin-left: 2%;">
                                    <option>Segunda-Feira</option>
                                    <option>Terça-Feira</option>
                                    <option>Quarta-Feira</option>
                                    <option>Quinta-Feira</option>
                                    <option>Sexta-Feira</option>
                                </select>-->
                            </div>

                            <div class="form-group">
                                <select class="form-control custom-form" id="select-mes" name="transfer_day" placeholder="Selecione o dia do recebimento" style="display: none;">
                                    @for ($i = 1; $i < 31; $i++)
                                        <option>Dia {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control custom-form" id="select-dia" name="transfer_day" placeholder="Selecione o dia do recebimento" style="display: none;">
                                    <option value="1">Segunda-Feira</option>
                                    <option value="2">Terça-Feira</option>
                                    <option value="3">Quarta-Feira</option>
                                    <option value="4">Quinta-Feira</option>
                                    <option value="5">Sexta-Feira</option>
                                </select>
                            </div>

                            <!--<div class="row" style="">
                                <div class="form-group" style="text-align: left;">
                                    <label class="radio-inline control-label custom-label">Data de Recebimento</label>
                                    <div style="font-size: 2px;">
                                        <label class="radio-inline control-label custom-label-sm">
                                            <input type="radio" name="radio-recebimento" id="radio-dia" value="">Diariamente
                                        </label>

                                        <label class="radio-inline control-label custom-label-sm">
                                            <input type="radio" name="radio-recebimento" id="radio-mes" value="">Mensalmente
                                        </label>
                                        <select class="form-control custom-form-sm" id="select-mes" style="display: inline; margin-left: 2%;">
                                            @for ($i = 1; $i < 31; $i++)
                                                <option>Dia {{ $i }}</option>
                                            @endfor
                                        </select>

                                        <label class="radio-inline control-label custom-label-sm">
                                            <input type="radio" name="radio-recebimento" id="radio-semana" value="">Semanalmente
                                        </label>
                                        <select class="form-control custom-form-sm" placeholder="Selecione o Banco" style="display: inline; margin-left: 2%;">
                                            <option>Segunda</option>
                                            <option>Terça</option>
                                            <option>Quarta</option>
                                            <option>Quinta</option>
                                            <option>Sexta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>-->

                            <div class="form-group" style="font-family: Titillium Web;">
                                <button id="cadastrar-conta-modal" type="submit" class="btn btn-blue btn-block">Salvar Conta Bancária</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
