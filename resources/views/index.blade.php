<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Ventas Laravel Vue Js- IncanatoIT">
    <meta name="author" content="Incanatoit.com">
    <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Sistema Ventas - IncanatoIT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div id="app" >
        @include('sistema.header')
        <div class="app-body">
            @auth
                
                @role('administrador')
                    @include('sidebar.sidebarAdministrador')
                @endrole
                @role('cliente')
                    @include('sidebar.sidebarCliente')
                @endrole
                @role('repartidor')
                    @include('sidebar.sidebarRepartidor')
                @endrole
                @yield('contenido')
            @else
                No tiene acceso al sistema , no se que chingaos  hace aqui :v
            @endauth
            
        </div>
    </div>

    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    <script src="{{ asset('coreui/vendors/js/jquery.min.js')}}"></script>
    <script src="{{ asset('coreui/vendors/js/bootstrap.min.js')}}"></script>
    
</body>
</html>