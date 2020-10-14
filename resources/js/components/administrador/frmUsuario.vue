<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Admin</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Usuario
                    <button type="button" @click="abrirModal('usuario','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="name">Usuarios</option>
                                <option value="nombre">Nombres</option>
                                <option value="apellidos">Apellidos</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarUsuario(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol </th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="usuario in arrayUsuario" :key="usuario.id">
                                <td v-text="usuario.name"></td>
                                <td v-text="usuario.nombreCompleto"></td>
                                <td v-text="usuario.email"></td>
                                <td v-text="usuario.roles[0].name"></td>
                                <td>
                                        <button type="button" @click="abrirModal('usuario','actualizar',usuario)" class="btn btn-success btn-sm">
                                        <i class="icon-pencil"></i>
                                        </button> 

                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminarUsuario(usuario.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' :'']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page">1</a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-success">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <template v-if="tipoAccion==1">
                            
                                   <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Roles</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="rol">
                                                <option value="0" disabled>Seleccione</option>
                                                <option value="repartidor">Repartidor</option>
                                                <option value="administrador">Administrador</option>
                                                <option value="cliente">Cliente</option>
                                            </select>                                        
                                        </div>
                                    </div>  
                                
                            </template>
                            <template v-else>

                                    <template v-if="rol=='cliente'">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Roles</label>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="rol">
                                                    <option value="0" disabled>Seleccione</option>
                                                    <option value="cliente" disabled>Cliente</option>
                                                </select>                                        
                                            </div>
                                        </div>  
                                    </template>

                                    <template v-else>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Roles</label>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="rol">
                                                    <option value="0" disabled>Seleccione</option>
                                                    <option value="repartidor" disabled>Repartidor</option>
                                                    <option value="administrador" disabled>Administrador</option>
                                                </select>                                        
                                            </div>
                                        </div>  
                                    </template>
                                
                            </template>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control form-control-sm" placeholder="Nombres">
                                </div>
                            </div>

                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellidos" class="form-control form-control-sm" placeholder="Apellidos">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Name</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control form-control-sm" placeholder="Login">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Password</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="password" class="form-control form-control-sm" placeholder="Password">
                                </div>
                            </div>

                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="email" class="form-control form-control-sm" placeholder="Email">
                                </div>
                            </div>


                        <template v-if="tipoAccion==1">
                            <template v-if="rol!='administrador'">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control form-control-sm" placeholder="Telefono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control form-control-sm" placeholder="Direccion">
                                    </div>
                                </div>
                            </template>


                            <template v-if="rol=='repartidor'">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cedula ID</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cedulaID" class="form-control form-control-sm" placeholder="Cedulo ID">
                                    </div>
                                </div>
                            </template> 

                            <template v-if="rol=='cliente'">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="empresa" class="form-control form-control-sm" placeholder="Empresa">
                                    </div>
                                </div>
                            </template> 
                        </template>



                            <div v-show="errorRol" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjRol" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCliente()">Modificar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
      </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data() {
            return {
                id: 0,
                nombre: '',
                apellidos: '',
                email: '',
                name: '',
                password: '',
                rol: '',
                arrayUsuario: [],
                arrayDato: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,


                empresa :'',
                cedulaID :'',
                telefono :'',
                direccion : '',

                errorRol: 0,
                errorMostrarMsjRol: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'nombre',
                buscar: ''
            }
        },
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            listarUsuario(page, buscar, criterio) {
                let me = this;
                var url = '/usuario?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta   = response.data;
                        me.arrayUsuario = respuesta.usuario.data;
                        me.pagination   = respuesta.pagination;
                        console.log(pagination);
                        // console.log(response.data);
                        // console.log(arrayUsuario);
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarUsuario(page, buscar, criterio);
            },
            registrarUsuario() {
                if (this.validarCliente()) {
                    return;
                }
                let me = this;
                axios.post('/usuario/guardar', {
                    'nombre'    : this.nombre,
                    'apellidos' : this.apellidos,
                    'name'      : this.name,
                    'password'  : this.password,
                    'email'     : this.email,
                    'rol'       : this.rol,
                    'empresa'   : this.empresa,
                    'cedulaID'  : this.cedulaID,
                    'telefono'  : this.telefono,
                    'direccion' : this.direccion,
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarUsuario(1, '', 'nombre');
                    iziToast.success({
                            title   : 'Exito!',
                            message : 'Se ha registrado un nuevo usuario',
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            },
            actualizarCliente() {
                if (this.validarCliente()) {
                    return;
                }
                let me = this;
                axios.post('/usuario/actualizar', {
                    'nombre'    : this.nombre,
                    'apellidos' : this.apellidos,
                    'name'      : this.name,
                    'password'  : this.password,
                    'email'     : this.email,
                    'rol'       : this.rol,
                    'empresa'   : this.empresa,
                    'cedulaID'  : this.cedulaID,
                    'telefono'  : this.telefono,
                    'direccion' : this.direccion,
                    'id'        : this.id
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarUsuario(1, '', 'nombre');
                    iziToast.info({
                            title: 'Exito!',
                            message: 'Se ha actualizado el nombre',
                    });

                }).catch(function(error) {
                    console.log(error);
                });
            },
            activarCliente(id) {
                swal({
                    title: 'Esta seguro de activar este usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/usuario/activar', {
                            'id': id
                        }).then(function(response) {
                            me.listarUsuario(1, '', 'nombre');
                            swal(
                                'Desactivado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                            )
                        }).catch(function(error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            desactivarCliente(id) {
                swal({
                    title: 'Esta seguro de desactivar este usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/usuario/desactivar', {
                            'id': id
                        }).then(function(response) {
                            me.listarUsuario(1, '', 'nombre');
                            swal(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                            )
                        }).catch(function(error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            eliminarUsuario(id) {
                swal({
                    title: 'Esta seguro de eliminar esta usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/usuario/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarUsuario(1, '', 'nombre');
                            swal(
                                'Eliminado!',
                                'El registro ha sido eliminado con éxito.',
                                'success'
                            )
                        }).catch(function(error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            validarCliente() {
                this.errorRol = 0;
                this.errorMostrarMsjRol = [];

                if (!this.nombre) this.errorMostrarMsjRol.push("Debe completar el campo Nombres ");
                if (!this.apellidos) this.errorMostrarMsjRol.push("Debe completar el campo Apellidos ");
                if (!this.name) this.errorMostrarMsjRol.push("Debe completar el campo Login ");
                if (!this.password) this.errorMostrarMsjRol.push("Debe completar el campo Password ");
                if (!this.email) this.errorMostrarMsjRol.push("Debe completar el campo Email ");
                //if (!this.estado) this.errorMostrarMsjRol.push("Debe completar el campo Estado ");
                if (this.errorMostrarMsjRol.length) this.errorRol = 1;
                return this.errorRol;
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.rol = '';
                this.nombre = '';
                this.nombre = '';
            },
            datosUsuario(email){
                let me = this;
                url ='/cliente/dato?email='+email;

                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayDato = respuesta.dato[0];
                    // console.log(respuesta["dato"][0]["apellidos"]);
                    console.log(me.arrayDato[0]);
                }).catch(function(error){
                    console.log(error);
                })
            },
            abrirModal(modelo, accion, data = []) {

                switch (modelo) {
                    case "usuario":
                        {
                            switch (accion) {
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Usuario'
                                        this.nombre = '';
                                        this.apellidos = '';
                                        this.name = '';
                                        this.password = '';
                                        this.email = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Usuario';
                                        this.tipoAccion = 2;
                                        this.idCliente = data['id'];
                                        this.rol = data.roles[0].name;
                                        this.nombre =   data['nombre'];
                                        this.apellidos = data['apellidos'];
                                        this.name =     data['name'];
                                        this.password =  "";
                                        this.email =        data['email'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarUsuario(1, this.buscar, this.criterio);
        }
    }
</script>
<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }
    
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    
    .div-error {
        display: flex;
        justify-content: center;
    }
    
    .text-error {
        color: red !important;
        font-weight: bold;
    }
</style>