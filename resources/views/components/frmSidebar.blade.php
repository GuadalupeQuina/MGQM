{{-- Plantilla2 --}}
<section id="banner">
    <div class="bg-color">
      <header id="header">
        <div class="container">
          <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#about">Nosotros</a>
            <a href="#event">Reservar</a>
            <a href="#menu-list">Menu</a>
            <a href="#contact">Pedido</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/index') }}">Escritorio</a>
                @else
                    <a href="{{ route('login') }}">Iniciar Sesion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrarse</a>
                    @endif
                @endauth
            @endif
          </div>
          <!-- Use any element to open the sidenav -->
          <span onclick="openNav()" class="pull-right menu-icon">☰</span>
        </div>
      </header>
      <div class="container">
        <div class="row">
          <div class="inner text-center">
            <h1 class="logo-name">Bienvenido</h1>
            {{-- <h2>Food To fit your lifestyle & health.</h2>
            <p>Specialized in Indian Cuisine!!</p> --}}
          </div>
        </div>
      </div>
    </div>
</section>