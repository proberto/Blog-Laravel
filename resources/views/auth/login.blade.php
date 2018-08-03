@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#google-access, #fb-access").click(function(){                 
                 $('#modal-redes-sociais').modal('show');
            });

            $("#forgot-pass").click(function(){                 
                 $('#modal-esqueceu-senha').modal('show');
            });            
        });
    </script> 
@endsection

@section('content')
    @include('layouts.partials.navbar-top-login')

    <div class="content"> 
    
        @include('layouts.partials.modal-forgot-password')

        <div class="row">            
            <div class="col-md-4 col-md-offset-4 login-card">
                <div class="row" style="text-align: center;">
                    <div class="col-md-6 col-md-offset-3" style="margin-bottom:8%; margin-top:8%;">
                        <div class="row" style="margin-bottom:8%;">
                            <img src="img/logo-branco.png">
                        </div>

                        <!--<div class="row" style="margin-bottom:4%;">
                            <a id="google-access" href="" onclick="return false;"><input id="google" type="image" class="img-responsive" src="img/btn-google.png"/></a>
                        </div>
                        <div class="row" style="margin-bottom:8%;">
                            <a id="fb-access" href="" onclick="return false;"><input id="face" type="image" class="img-responsive" src="img/btn-facebook.png"/></a>
                        </div>-->    
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}                  
                            
                            <div class="row" style="margin-bottom:1%;">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">                                      
                                    <input class="form-control blue-placeholder" type="text" name="email" id="email" placeholder="E-mail">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">                                      
                                    <input class="form-control blue-placeholder" type="password" name="password" id="password" placeholder="Senha">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>                        
                            <div class="row" style="margin-bottom:4%;">
                                <div class="checkbox">
                                    <label class="text-login">
                                        <input type="checkbox" name="remember">Lembre de Mim!
                                    </label>
                                </div>
                            </div>                        

                            <div class="row" style="margin-bottom:6%;">    
                                <div class="form-group" style="font-family: Titillium Web;">                        
                                    <button id= "entrar" type="submit" class="btn btn-blue-light btn-block btn-lg">Entre Agora!</button>  
                                </div>
                            </div>
                        </form>

                        <div class="row" style="margin-bottom:2%;">
                            <a id="forgot-pass" href="" onclick="return false;"><p class="text-login">Esqueceu sua Senha?</p></a>
                        </div>
                        <div class="row" style="margin-bottom:2%;">
                            <div style="display:inline-block;"><p class="text-login">Não tem Conta?</p></div>
                            <button type="button" onclick="window.location='{{ url("/register") }}'" class="btn btn-green btn-block btn-lg">Registre-se</button>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
@endsection