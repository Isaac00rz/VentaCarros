<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel = "stylesheet" href = "{{ asset('css/menu.css') }}"/>
        <script src="{{ asset('js/jquery-1.3.2.js') }}"></script>
    </head>
    <body>
        <div class="header"></div>
        <div class="scroll"></div>
        <ul id="navigation">
            <li class="home"><a href="{{ url('/home') }}" title="Home"></a></li>
            <li class="about"><a href="{{ url('/Vendedores') }}" title="Vendedores"></a></li>
            <li class="search"><a href="{{ url('/Clientes')}}" title="Clientes"></a></li>
            <li class="rssfeed"><a href="{{ url('/Autos') }}" title="Autos"></a></li>
            <li class="podcasts"><a href="{{ url('/Cotizacion')}}" title="Cotización"></a></li>
            <li class="venta"><a href="{{ url('/Ventas')}}" title="Venta"></a></li>
            <li class="cobranza"><a href="{{ url('/')}}" title="Cobranza"></a></li>
            <li class="reportes"><a href="{{ url('/')}}" title="Reportes"></a></li>
            <li class="contact"><a href="{{ route('logout') }}" title="Salir"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 
             </a></li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <script type="text/javascript">
            $(function() {
                $('#navigation a').stop().animate({'marginLeft':'-85px'},1000);

                $('#navigation > li').hover(
                    function () {
                        $('a',$(this)).stop().animate({'marginLeft':'-2px'},200);
                    },
                    function () {
                        $('a',$(this)).stop().animate({'marginLeft':'-85px'},200);
                    }
                );
            });
        </script>
