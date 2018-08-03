<nav class="navbar navbar-default custom-navbar">
  <div class="container-fluid">
    <div class="navbar-header" style="margin-left: 7%;">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/vendas" style="color: #386BDD;">Home</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
      </ul>      
      
      <ul class="nav navbar-nav navbar-right" style="margin-right: 7%;">       
        <!--<li><a href="">Relatório de Vendas</a></li>-->
        
        <li><a href="/transacoes">Transações</a></li>
        <!--<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Minha Conta <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Editar</a></li>
            <li><a href="#">Adicionar Conta Bancária</a></li>            
          </ul>
        </li>-->
        <li><a href="/conta">Minha Conta</a></li>
        <!--<li><a href="/login">Sair</a></li>-->
        @if (!Auth::guest())
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                  <li>
                      <a href="{{ url('/logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Sair
                      </a>

                      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  </li>
              </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>