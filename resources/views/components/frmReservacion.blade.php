{{-- plantilla2 --}}
    <section id="event">
        <div class="bg-color" class="section-padding">
        <div class="container">

            <div class="row">
                <div class="col-xs-12 text-center" style="padding:60px;">
                    <h1 class="header-h">Realice su Reservacion</h1>
                    {{-- <p class="header-p">Decorations 100% complete here</p> --}}
                </div>


                <div class="col-md-12" style="padding-bottom:60px;">
                    <div class="item active left">
                        {{-- <div class="col-md-6 col-sm-6 left-images">
                            <img src="{{asset('delicious/img/res02.jpg')}}" class="img-responsive">
                        </div> --}}
                        <div class="col-md-12 col-sm-6 details-text">
                            <div class="content-holder">
                                @if (!$formulario)
                                    <h2>Estamos esperandote</h2>
                                    <button class="btn btn-info btn-read-more" wire:click='mostrarFormularioReservacion()'>Realiza su reserva</button>
                                @endif

                                @if($formulario)
                                    @auth
                                        <div class="card">
                                            <div class="card-header">
                                                <h2></h2>
                                            </div>
                                            @if ($siguiente==0)
                                                <div class="card-body">
                                                    <div class ="form-group">
                                                        <label class="">Comensales {{ $comensales }}</label>
                                                        <input wire:model='comensales' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Telefono {{ $telefono }}</label>
                                                        <input wire:model='telefono' style="color:white; backgrounp-color:white ;"  class ="form-control">
                                                    </div>

                                                        <div class="form-group">
                                                            <label class="">Fecha :  {{ $fecha }}</label>
                                                            <input type="date" wire:model='fecha' style="color:white;" class="form-control label-floating is-empty" name="date" id="date" placeholder="Date" data-rule="required" data-msg="This field is required" />
                                                            <div class="validation"></div>
                                                        </div>

                                                    <div class ="form-group">
                                                        <label class="">Hora {{ $hora }}</label>
                                                        <input type="time" wire:model='hora' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Observacion {{ $observacion }}</label>
                                                        <input wire:model='observacion' style="color:white;" class ="form-control">
                                                    </div>
                                                </div>                                                
                                            @endif
                                            @if ($siguiente==1)
                                                <h2>Muchas Gracias</h2>
                                                <p>Su reservacion fue realizada con exito... puede verificar su reservacion</p>
                                                <p>Desea ir al sistema?</p>
                                                <a class="btn btn-sm btn-info" href="{{ url('index')}}">Ir</a>
                                                <button wire:click='finalizarReserva()' class="btn btn-sm btn-info">Cerrar</button>

                                            @endif

                                            <div class="card-footer">
                                                @php  $usuario_id =  Auth::user()->id @endphp
                                                @if ($siguiente==0)
                                                    <button wire:click='guardarReservacionAuth({{ $usuario_id }})' class="btn btn-sm btn-info">Realizar Reservacion</button>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="card">
                                            
                                            @if ($siguiente==0)
                                                <div class="card-header">
                                                    <h2>Ingrese sus datos personales</h2>
                                                </div>
                                                <div class="card-body">
                                                    <div class ="form-group">
                                                        <label class="">Nombres {{ $nombres }}</label>
                                                        <input wire:model='nombres' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Apellidos {{ $apellidos }}</label>
                                                        <input wire:model='apellidos' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Empresa {{ $empresa }}</label>
                                                        <input wire:model='empresa' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Telefono {{ $telefono }}</label>
                                                        <input wire:model='telefono' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Direccion {{ $direccion }}</label>
                                                        <input wire:model='direccion' style="color:white;" class ="form-control">
                                                    </div>
                                                </div>                                                
                                            @endif
                                            @if ($siguiente==1)
                                                <div class="card-header">
                                                    <h2>Ingrese sus credenciales de usuario</h2>
                                                </div>
                                                <div class="card-body">
                                                    <div class ="form-group">
                                                        <label class="">Usuario {{ $name }}</label>
                                                        <input wire:model='name' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Email {{ $email }}</label>
                                                        <input wire:model='email' type="email" style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Contraseña {{ $password }}</label>
                                                        <input wire:model='password' type="password" style="color:white;" class ="form-control">
                                                    </div>
                                                </div> 
                                            @endif
                                            @if ($siguiente==2)
                                                <div class="card-header">
                                                    <h2>Ingrese sus datos de reservacion</h2>
                                                </div>
                                                <div class="card-body">
                                                    <div class ="form-group">
                                                        <label class="">Comensales {{ $comensales }}</label>
                                                        <input wire:model='comensales' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Telefono {{ $telefono }}</label>
                                                        <input wire:model='telefono' style="color:white; backgrounp-color:white ;"  class ="form-control">
                                                    </div>

                                                        <div class="form-group">
                                                            <label class="">Fecha :  {{ $fecha }}</label>
                                                            <input type="date" wire:model='fecha' style="color:white;" class="form-control label-floating is-empty" name="date" id="date" placeholder="Date" data-rule="required" data-msg="This field is required" />
                                                            <div class="validation"></div>
                                                        </div>

                                                    <div class ="form-group">
                                                        <label class="">Hora {{ $hora }}</label>
                                                        <input type="time" wire:model='hora' style="color:white;" class ="form-control">
                                                    </div>

                                                    <div class ="form-group">
                                                        <label class="">Observacion {{ $observacion }}</label>
                                                        <input wire:model='observacion' style="color:white;" class ="form-control">
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($siguiente==3)
                                                <h2>Muchas Gracias</h2>
                                                <p>Su reservacion fue realizada con exito... puede iniciar sesion con su credenciales de usuario y verificar su reservacion</p>
                                                <p>Desea iniciar sesion?</p>
                                                <a class="btn btn-sm btn-info" href="{{ route('login')}}">Iniciar Sesion</a>
                                                <button wire:click='finalizarReserva()' class="btn btn-sm btn-info">Cerrar</button>

                                            @endif
                                            <div class="card-footer">
                                                @if ($siguiente < 2 )
                                                    <button wire:click='siguientePaso()' class="btn btn-sm btn-info">Siguiente</button>
                                                @endif

                                                @if ($siguiente > 0 && $siguiente < 3 )
                                                    <button wire:click='anteriorPaso()' class="btn btn-sm btn-info">Anterior</button>
                                                @endif
                                                @if ($siguiente==2)
                                                    <button wire:click='guardarReservacionLogout()' class="btn btn-sm btn-info">Realizar Reservacion</button>
                                                @endif

                                            </div>
                                        </div>
                                    @endauth

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@role('repartidor')
<section id="event">
    <div class="bg-color" class="section-padding">
      <div class="container">

        <div class="row">
            <div class="col-xs-12 text-center" style="padding:60px;">
                <h1 class="header-h">Ud es un repartidor</h1>
                <p class="header-p">Las reservaciones no estan disponibles para ud</p>
            </div>
        </div>
      </div>
    </div>
</section>
@endrole