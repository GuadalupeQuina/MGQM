@role('administrador')
    @include('sidebar.sidebaradministrador')
    @yield('contenido')
@endrole

@role('cliente')
    @include('sidebar.sidebarcliente')
    @include('contenido.cliente')          
@endrole

@role('repartidor')
    @include('sidebar.sidebarrepartidor')
    @include('contenido.repartidor')            
@endrole
