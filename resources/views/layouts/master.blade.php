<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="token" name="csrf-token" content="{{ csrf_token() }}">

        <title>Blukan</title>

        <!-- Bootstrap Flatly Theme -->
        <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet">

        <!--Temp css Flatly-->
        <link rel="stylesheet" type="text/css" href="{{ url('css/flatly.css') }}"/>

        <!-- Blukan's CSS file -->
        <link rel="stylesheet" type="text/css" href="{{ url('css/main.css') }}"/>
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/fonts/glyphicons-halflings-regular.ttf" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/fonts/glyphicons-halflings-regular.woff" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/fonts/glyphicons-halflings-regular.woff2" rel="stylesheet">
        

        <!-- Titilium Web -->
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>

        <!--Full Calendar-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css">
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css">-->

        <!--MDB
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.3.1/css/mdb.min.css">-->        

        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-88767323-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
        
    </head>
    <body class="background-img">
        <div class="container-fluid">
            @yield('content')
        </div>

        @include('layouts.partials.termos')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>    
        
        <!-- Latest compiled and minified JavaScript
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.mask.min.js"></script>
        <script src="js/jquery.cpfcnpj.min.js"></script>        

        @yield('scripts')
        
    </body>

    @include('layouts.partials.footer')
</html>