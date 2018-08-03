@extends('layouts.master')

@section('scripts')
 
@endsection

<div style="margin-bottom: 4%;"></div>

@section('content')
    <div class="content">
        @include('layouts.partials.center-logo')

        <div class="row">            
            <div class="col-md-4 col-md-offset-4 login-card">
                <div class="row" style="text-align: center;">
                    <div class="col-md-6 col-md-offset-3" style="margin-bottom:8%; margin-top:8%;">
                        <div class="row" style="margin-bottom:4%;">
                            <input id="google" type="image" class="img-responsive" src="img/btn-google.png"/>
                        </div>
                        <div class="row" style="margin-bottom:8%;">
                            <input id="face" type="image" class="img-responsive" src="img/btn-facebook.png"/>
                        </div> 
                        <div class="row" style="margin-bottom:2%;">
                            <p class="text-login">Ou entre com seu E-mail</p>
                        </div>
                        <div class="row" style="margin-bottom:1%;">
                            <div class="form-group">                                      
                                <input class="form-control blue-placeholder" type="text" name="email" id="email" placeholder="E-mail">
                            </div>
                            <div class="form-group">                                      
                                <input class="form-control blue-placeholder" type="password" name="senha" id="senha" placeholder="Senha">
                            </div>
                        </div>                        
                        <div class="row" style="margin-bottom:4%;">
                            <div class="checkbox">
                                <label class="text-login">
                                    <input type="checkbox">Lembre de Mim!
                                </label>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:6%;">    
                            <div class="form-group" style="font-family: Titillium Web;">                        
                                <button type="button" onclick="window.location='{{ url("/conta") }}'" class="btn btn-green btn-block btn-lg">Entrar Agora!</button>  
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:2%;">
                            <p class="text-login">Esqueceu sua Senha?</p>
                        </div>
                        <div class="row" style="margin-bottom:2%;">
                            <div style="display:inline-block;"><p class="text-login">Não tem Conta?</p></div>
                            <div style="display:inline-block; margin-left: 3%;"><button type="button" onclick="window.location='{{ url("/cadastro") }}'" class="btn btn-green">Registre-se</button></div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
@endsection