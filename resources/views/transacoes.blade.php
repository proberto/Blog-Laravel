@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).ajaxStart(function(){
              $('.modal-footer').hide();
              $('.modal-body').text("Estornando Transação...")
            });

            $(document).ajaxStop(function(){
              $('.modal-footer').hide();
              $('.modal-body').text("Transação estornada. Aguarde, a página será atualizada.")
            });

            $('#confirma-estorno-post').on("click",function(){
                $.ajax({
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                    },
                    url: './transacoes/estorno',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        'id': $('#estorno-post').attr("data-id-transacao")
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                      window.alert('Ocorreu um erro durante o estorno.');
                    },
                    success: function(data){
                      window.location.reload();
                    }
                });
            })

            /*$('.pdf-post').on("click",function(){
                $.ajax({
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                    },
                    url: '/transacoes/teste/',
                    type: 'get',
                    success: function (data) {
                        window.alert("OK!!!");
                    },
                    data: $(this).data("id")
                });
            })*/

        });
    </script>
@endsection

@section('content')
    @include('layouts.partials.navbar-top')

    <div class="content">

        @include('layouts.partials.center-logo')

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Estorno</h4>
              </div>
              <div class="modal-body">
                Você realmente deseja estornar a transação?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <!-- This is the submit button of the form -->
                <button type="button" class="btn btn-green" id="confirma-estorno-post">Confirmar</button>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-8 col-md-offset-2" style="margin-top: 3%;">
            <div class="row">
                <div class="panel panel-default lista-transacoes">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h3 class="lista-transacoes-title">Lista de Transações</h3>
                            </div>
                            <div class="col-sm-6 text-right">
                                <img src="img/ico-lista-branco.png" style="vertical-align: middle;"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--Lista de transacoes -->
                <div class="panel-group panel-default-transacoes" id="accordion">
                  @foreach($transacoes as $arr)

                      <div class="panel-default-transacoes">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $loop->iteration }}">
                            <div class="panel-heading transacao-head">
                                <div style="display:inline">
                                    <div class="col-md-8 text-left">
                                        <h4 class="panel-title">
                                            <div class="transacoes-title">{{ $arr['nome'] }} | CPF: {{ $arr['cpf'] }} | Data: {{ $arr['data'] }}</div>
                                        </h4>
                                    </div>

                                    <div class="col-md-2" style="padding: 0px;">
                                        @if($arr['status'] == 'paid')
                                            <img src="img/bot-aprovado.png">
                                        @elseif($arr['status'] == 'refused')
                                            <img src="img/bot-negado.png">
                                        @elseif($arr['status'] == 'refunded')
                                            <div style="color: red;">Estornado</div>
                                        @elseif($arr['status'] == 'processing')
                                            <img src="img/bot-aguardando-aprovacao.png">
                                        @endif
                                    </div>
                                    @if($arr['status'] == 'paid')
                                        <div class="transacao-mais-info pull-right">Mais Informações</div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        @if($arr['status'] == 'paid')
                            <div id="collapse{{ $loop->iteration }}" class="panel-collapse collapse transacao-body">
                              <div class="panel-body">
                                <div class="row transacoes-body-font">
                                    <div class="col-xs-3 text-left" style="margin-left: 3%;">
                                        <div class="row">
                                            <img src="img/ico-emitir-recibo.png" style="vertical-align: middle; margin-right: 5px;"/>Gerar Nota Fiscal
                                        </div>
                                        <div style="margin-top: 3%"></div>
                                        <div class="row">
                                            <img src="img/ico-emitir-recibo.png" style="vertical-align: middle; margin-right: 5px; opacity:0;"/>
                                            <a href="/transacoes/recibo/{{ $arr['id_transaction'] }}" class="pdf-post" target="_blank" data-id="{{ $arr['id_transaction'] }}" style="color: #FFF;">&bull; PDF</a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 text-left">
                                        <div class="row">
                                            <a href="" class="estorno-post" id="estorno-post" data-id-transacao="{{ $arr['id_transaction'] }}" style="color: #FFF;" data-toggle="modal" data-target="#myModal">
                                                <img src="img/ico-estorno.png" style="vertical-align: middle; margin-right: 5px;"/> Estorno
                                            </a>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                        @endif
                      </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
