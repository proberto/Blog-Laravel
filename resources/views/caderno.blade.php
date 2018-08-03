@extends('layouts.master')

@section('scripts')
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.3.1/js/mdb.min.js"></script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/locale/pt-br.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            jQuery(function($) {
                var panelList = $('#draggablePanelList');

                panelList.sortable({
                    // Only make the .panel-heading child elements support dragging.
                    // Omit this to make then entire <li>...</li> draggable.

                    update: function() {
                        $('.panel', panelList).each(function(index, elem) {
                             var $listItem = $(elem),
                                 newIndex = $listItem.index();

                             // Persist the new indices.
                        });
                    }
                });
            });

            $('.clickable-patient').on('click',function(){
              var parent_li= $(this).closest("li"); //li pai da div clicada

              var panel_new = $('#editable-li').html(); //panel com campos editaveis
              var $html_panel= $(panel_new);
              var name_edit= $(this).find('.p-name').find('.span-name').text();
              var fone_edit= $(this).find('.p-name').find('.span-fone').text();
              var obs_edit= $(this).find('.p-obs').find('.span-obs').text();

              $html_panel.find("#nome-paciente").attr("value", name_edit);
              $html_panel.find("#fone-paciente").attr("value", fone_edit);
              $html_panel.find("#observacao-paciente").attr("value", obs_edit);
              $html_panel.find(".glyphicon-plus").toggleClass("glyphicon-ok");

              parent_li.empty().append($html_panel);
            });

            $(".nome-profissional").on('click',function(){
                alert("doctor clicked!!!");
            });

            $('#prioridade-id').click(function(){
              $(this).toggleClass('btn-color-priority');
            });

            $('#atendido-id').click(function(){
              $(this).toggleClass('btn-color-atendido');
            });

            $('#chegou-id').click(function(){
              $(this).toggleClass('btn-color-chegou');
            });

            $('#cadastrar-profissional').click(function(){
                 $('.cadastro-profissional').show();
                 $('.marcacao-consulta').hide();
                 $('.lista-pacientes').hide();
                 $('.ficha-paciente').hide();
            });

            $('#cancel-cadastro-profissional').click(function(){
                 $('.ficha-paciente').hide();
                 $('.cadastro-profissional').hide();
                 $('.marcacao-consulta').hide();
                 $('.lista-pacientes').show();
            });

            $('#marcar-consulta').click(function(){
                 $('.cadastro-profissional').hide();
                 $('.lista-pacientes').hide();
                 $('.ficha-paciente').hide();
                 $('.marcacao-consulta').show();
            });

            $('#cancel-cadastro-paciente').click(function(){
                 $('.marcacao-consulta').hide();
                 $('.ficha-paciente').hide();
                 $('.cadastro-profissional').hide();
                 $('.lista-pacientes').show();
            });

            $('#ficha-paciente').click(function(){
                 $('.cadastro-profissional').hide();
                 $('.lista-pacientes').hide();
                 $('.marcacao-consulta').hide();
                 $('.ficha-paciente').show();
            });

            $('#cancel-ficha-paciente').click(function(){
                 $('.marcacao-consulta').hide();
                 $('.ficha-paciente').hide();
                 $('.cadastro-profissional').hide();
                 $('.lista-pacientes').show();
            });

            $('#datetimepicker1').datepicker();

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
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var step = 25;
            var scrolling = false;

            // Wire up events for the 'scrollUp' link:
            $("#scrollUp").bind("click", function(event) {
                event.preventDefault();
                // Animates the scrollTop property by the specified
                // step.
                $("#box").animate({
                    scrollTop: "-=" + step + "px"
                });
            }).bind("mouseover", function(event) {
                scrolling = true;
                scrollContent("up");
            }).bind("mouseout", function(event) {
                scrolling = false;
            });


            $("#scrollDown").bind("click", function(event) {
                event.preventDefault();
                $("#box").animate({
                    scrollTop: "+=" + step + "px"
                });
            }).bind("mouseover", function(event) {
                scrolling = true;
                scrollContent("down");
            }).bind("mouseout", function(event) {
                scrolling = false;
            });

            function scrollContent(direction) {
                var amount = (direction === "up" ? "-=1px" : "+=1px");
                $("#box").animate({
                    scrollTop: amount
                }, 1, function() {
                    if (scrolling) {
                        scrollContent(direction);
                    }
                });
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'title',
                center: '',
                right: 'prev,next'
            },
            aspectRatio: 1.1,
            showNonCurrentDates: false,
            fixedWeekCount: false,
            handleWindowResize: true,
            dayClick: function(date, jsEvent, view) {
              $(this).css('background-color', 'white');
              //alert('Clicked on: ' + date.format());
            }

            //selectable: true,
            //selectHelper: true,
            /*select: function(start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                        true // make the event "stick"
                    );
                }
                calendar.fullCalendar('unselect');
            },
            editable: true,*/
            /*events: [
                {
                    title: 'Consulta',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Consulta',
                    start: new Date(y, m, 8)
                },
                {
                    title: 'Consulta',
                    start: new Date(y, m, 15)
                },
                {
                    title: 'Consulta',
                    start: new Date(y, m, 22)
                },
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 29)
                },

                /*{
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ],*/
        });
    });
    </script>
@endsection

@section('content')
    @include('layouts.partials.navbar-top')

    <div class="content">

        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-4">
                    <button id="marcar-consulta" class="btn btn-info btn-block">Marcação de Consulta</button>
                </div>
                <div class="col-md-4">
                    <button id="ficha-paciente" class="btn btn-info btn-block">Ficha do Paciente</button>
                </div>
                <div class="col-md-4">
                    <img src="img/blukan-logo.png" class="pull-right">
                </div>
            </div>

            <div class="row cadastro-profissional" style="background-color: #B2DFDB; margin-top: 3%;" hidden>
                <div class="row" style="padding-left: 3%;">
                    <div class="col-md-12"><h4>DADOS DO PROFISSIONAL</h4></div>
                </div>

                <div class="row" style="padding: 3%;">
                   <form role="form" method="POST" action="#">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">

                                <input class="form-control custom-form" type="text" name="nome" id="nome" placeholder="*Nome" >

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('especialidade') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="especialidade" id="especialidade" placeholder="*Especialidade" >

                                @if ($errors->has('especialidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('especialidade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="Valor da Consulta/Procedimento" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control custom-form" row="5" name="observacao" id="observacao" placeholder="Observação"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success pull-right">Salvar</button>
                            <button type="button" id= "cancel-cadastro-profissional" class="btn btn-danger pull-right" style="margin-right: 2%;">Cancelar</button>
                        </div>
                   </form>
                </div>
            </div>

            <div class="row marcacao-consulta" style="background-color: #B2DFDB; margin-top: 3%;" hidden>
                <div class="row" style="padding-left: 3%;">
                    <div class="col-md-12"><h4>DADOS DO CONSULTA</h4></div>
                </div>

                <div class="row" style="padding: 3%;">
                   <form role="form" method="POST" action="#">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('nome-paciente') ? ' has-error' : '' }}">

                                <input class="form-control custom-form" type="text" name="nome-paciente" id="nome-paciente" placeholder="*Nome" >

                                @if ($errors->has('nome-paciente'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome-paciente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="celular" id="celular" placeholder="*Celular" >

                                @if ($errors->has('celular'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('celular') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="Data da Consulta" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                            <select class="form-control custom-form">
                              <option value="" disabled selected>Profissional</option>
                              <option>Dr. Fulano 1</option>
                              <option>Dr. Fulano 2</option>
                              <option>Dr. Fulano 3</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <label class="radio-inline control-label custom-label">Possui prioridade no atendimento?</label>
                            <label class="radio-inline control-label custom-label-sm" style="padding-right: 20px;">
                                <input type="radio" name="radio-priodidade" id="radio-sim" value="yes">Sim
                            </label>
                            <label class="radio-inline control-label custom-label-sm">
                                <input type="radio" name="radio-priodidade" id="radio-nao" value="no" checked="true">Não
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <textarea class="form-control custom-form" row="5" name="observacao" id="observacao" placeholder="Observação"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success pull-right">Salvar</button>
                            <button type="button" id= "cancel-cadastro-paciente" class="btn btn-danger pull-right" style="margin-right: 2%;">Cancelar</button>
                        </div>
                   </form>
                </div>
            </div>

            <div class="row ficha-paciente" style="background-color: #B2DFDB; margin-top: 3%;" hidden>
                <div class="row" style="padding-left: 3%;">
                    <div class="col-md-12"><h4>DADOS DO PACIENTE</h4></div>
                </div>

                <div class="row" style="padding: 3%;">
                   <form role="form" method="POST" action="#">
                        <div class="col-md-5">
                            <div class="form-group{{ $errors->has('nome-paciente') ? ' has-error' : '' }}">

                                <input class="form-control custom-form" type="text" name="nome-paciente" id="nome-paciente" placeholder="*Nome" >

                                @if ($errors->has('nome-paciente'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome-paciente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="celular" id="celular" placeholder="*Celular" >

                                @if ($errors->has('celular'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('celular') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="radio-inline control-label custom-label-sm" style="padding-right: 20px;">
                                <input type="radio" name="radiorecebimento" id="radio-mes" value="monthly">Masculino
                            </label>
                            <label class="radio-inline control-label custom-label-sm">
                                <input type="radio" name="radiorecebimento" id="radio-semana" value="weekly">Feminino
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="Data de Nascimento" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="CPF" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="RG" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="Email" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('valor-consulta') ? ' has-error' : '' }}">
                                <input class="form-control custom-form" type="text" name="valor-consulta" id="valor-consulta" placeholder="Telefone" >

                                @if ($errors->has('valor-consulta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor-consulta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--- Adress --->
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
                        </div>

                        <!--- Adress --->

                        <div class="col-md-8">
                            <div class="form-group">
                                <textarea class="form-control custom-form" row="5" name="observacao" id="observacao" placeholder="Observação"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-success pull-right">Salvar</button>
                            <button type="button" id= "cancel-ficha-paciente" class="btn btn-danger pull-right" style="margin-right: 2%;">Cancelar</button>
                        </div>
                   </form>
                </div>
            </div>

            <div class="row lista-pacientes" style="background-color: #B2DFDB; margin-top: 3%;">
                <div class="row" style="margin-top: 15px;">
                    <div class="col-sm-4 col-md-4">
                        <p style="padding: 3%;">SEGUNDA-FEIRA - 17 de FEVEREIRO de 2017</p>
                        <p class="cabecalho">Dr. Fulano</p>
                        <p class="cabecalho">Cardiologista</p>
                        <p class="cabecalho">R$ 200</p>
                    </div>
                    <div class="col-sm-4 col-md-4" style="padding-left: 0px;">
                        <div id="calendar-container" style="width: 350px;">
                          <div id="calendar"></div>
                        </div>

                    </div>
                    <div class="col-sm-4 col-md-4 text-center">
                        <div style="padding: 3%;"><button id="cadastrar-profissional" class=" btn btn-info">Cadastrar Profissional</button></div>

                        <!--a id="scrollUp" href="#">up</a>-->

                        <div id="box">
                            <ul style="padding-left:0px; margin-left:0px;">
                                @for ($i = 0; $i < 10; $i++)
                                    <li style="margin-bottom: 4%;">
                                      <div class="nome-profissional" id="item-profissional">
                                        <span class="glyphicon glyphicon-user" style="margin-right: 3%;"></span>
                                        Dr. Fulano Mendes de Oliveira{{ $i }}
                                      </div>
                                    </li>
                                @endfor
                            </ul>
                        </div>

                        <!--<a id="scrollDown" href="#">down</a>-->

                    </div>
                </div>

                <div class="row" style="padding: 3%;">
                    <ul id="draggablePanelList" class="list-unstyled">
                    @for($i=1;$i < 5 ; $i++ )
                        <li class="panel panel-info" id="{{$i}}">
                          <!--<div class="panel-heading">You can drag this panel.</div>-->
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7" style="vertical-align: middle;">
                                    <div class="clickable-patient">
                                      <p class="p-name"> <span class="span-name">Fulano dos Santos Menezes {{$i}}</span> | Tel: <span class="span-fone">(75)0000-0000 </span> <span class="glyphicon glyphicon-pencil"></span></p>
                                      <p class="p-obs">Obs: <span class="span-obs">paciente da revisão<span></p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="pull-right">
                                        <button id="prioridade-id" class="btn btn-xs btn-list-patients">Prioridade</button>
                                        <button id="chegou-id" class="btn btn-xs btn-list-patients">Chegou</button>
                                        <button class="btn btn-xs btn-list-patients" onClick="window.open('http://localhost:8000/vendas');">Pagamento</button>
                                        <button id="atendido-id" class="btn btn-xs btn-list-patients">Atendido</button>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </li>
                    @endfor
                        <li class="panel panel-info" id="editable-li">
                          <!--<div class="panel-heading">You can drag this panel.</div>-->
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4" style="vertical-align: middle;">
                                    <input class="form-control custom-form" type="text" name="nome-paciente" id="nome-paciente" placeholder="Nome" >
                                </div>
                                <div class="col-md-3">
                                   <input class="form-control custom-form" type="text" name="fone-paciente" id="fone-paciente" placeholder="Telefone" >
                                </div>
                                <div class="col-md-4">
                                   <input class="form-control custom-form" type="text" name="observacao-paciente" id="observacao-paciente" placeholder="Observação">
                                </div>
                                <div class="col-md-1">
                                    <a href="#" class="btn btn-circle btn-info"><span id="icon-save-add" class="glyphicon glyphicon-plus"></a>
                                </div>
                            </div>
                          </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
