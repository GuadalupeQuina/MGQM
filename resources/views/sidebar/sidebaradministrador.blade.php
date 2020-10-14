<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">           
                {{-- Escritorio --}}
                <li  @click="menu=0" class="nav-item">
                    <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
                </li>
                
                {{-- Menu --}}
                <li class="nav-title">
                    Menú
                </li>

                {{-- Clientes --}}
                <li @click="menu=1" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Clientes</span></a>
                </li>

                {{-- Reservas --}}
                <li @click="menu=2" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Reservas</span></a>
                </li>

                {{-- Mesas --}}
                <li @click="menu=13" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Mesas</span></a>
                </li>

                {{-- Pedidos --}}
                <li @click="menu=3" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Pedidos</span></a>
                </li>

                {{-- Orden Atencion --}}
                <li @click="menu=4" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i>Orden</span></a>
                </li>

                {{-- Menu --}}
                <li @click="menu=5" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Menú <span class="badge badge-success"></span></a>
                </li>
                
                {{-- Productos --}}
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Productos</a>
                    <ul class="nav-dropdown-items">
                        <li @click="menu=6" class="nav-item">
                            <a class="nav-link" href="#"><i class="icon-bag"></i>Categorías</a>
                        </li>
                        <li @click="menu=7" class="nav-item">
                            <a class="nav-link" href="#"><i class="icon-bag"></i>Platos</a>
                        </li>
                    </ul>
                </li>

                {{-- Repartidores --}}
                <li @click="menu=8" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Repartidores <span class="badge badge-success"></span></a>
                </li>


                {{-- Vehiculos --}}
                <li @click="menu=9" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Vehiculos <span class="badge badge-success"></span></a>
                </li>

                {{-- Acceso al sistema --}}
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Acesso</a>
                    <ul class="nav-dropdown-items">
                        <li @click="menu=10" class="nav-item">
                            <a class="nav-link" href="#"><i class="icon-bag"></i>Usuarios</a>
                        </li>
                        <li @click="menu=14" class="nav-item">
                            <a class="nav-link" href="#"><i class="icon-bag"></i>Roles</a>
                        </li>
                        <li @click="menu=11" class="nav-item">
                            <a class="nav-link" href="#"><i class="icon-bag"></i>Bitacora</a>
                        </li>
                    </ul>
                </li>

                {{-- Reporte --}}
                <li @click="menu=12" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Reportes <span class="badge badge-danger">PDF</span></a>
                </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>