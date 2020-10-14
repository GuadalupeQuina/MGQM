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
                    <i class="fa fa-align-justify"></i> Cliente
                    <button type="button" @click="abrirModal('cliente','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombres">Nombres</option>
                                <option value="apellidos">Apellidos</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarCliente(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarCliente(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Empresa</th>
                                <th>Telefono </th>
                                <th>Direccion</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                <td v-text="cliente.nombreCompleto"></td>
                                <td v-text="cliente.empresa"></td>
                                <td v-text="cliente.telefono"></td>
                                <td v-text="cliente.direccion"></td>
                                <td v-text="cliente.email"></td>
                                <template v-if="cliente.estado==1">
                                    <td><span class="badge badge-success">Activo</span></td>
                                </template>
                                <template v-else>
                                    <td class="text-center"><span class="badge badge-danger">Inactivo</span></td>
                                </template>
                                <td>
                                        <button type="button" @click="abrirModal('cliente','actualizar',cliente)" class="btn btn-success btn-sm">
                                        <i class="icon-pencil"></i>
                                        </button> 

                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminarCliente(cliente.id)">
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
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombres" class="form-control" placeholder="Nombres">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Login</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="login" class="form-control" placeholder="Login">
                                </div>
                            </div>
                              <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Password</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                              <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="empresa" class="form-control" placeholder="Empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Telefono">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Direccion">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div v-show="errorCliente" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCliente()">Guardar</button>
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
                idCliente: 0,
                nombres: '',
                apellidos: '',
                login: '',
                password: '',
                empresa: '',
                telefono: '',
                direccion: '',
                email: '',
                estado: '',
                arrayCliente: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorCliente: 0,
                errorMostrarMsjCliente: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'nombres',
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
            listarCliente(page, buscar, criterio) {
                let me = this;
                var url = '/cliente?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayCliente = respuesta.cliente.data;
                        me.pagination = respuesta.pagination;
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarCliente(page, buscar, criterio);
            },
            registrarCliente() {
                if (this.validarCliente()) {
                    return;
                }
                let me = this;
                axios.post('/cliente/guardar', {
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'login': this.login,
                    'password': this.password,
                    'empresa': this.empresa,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'email': this.email,
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarCliente(1, '', 'nombres');


                    iziToast.success({
                            title: 'Exito!',
                            message: 'Se ha registrado un nuevo cliente',
                    });



                }).catch(function(error) {
                    console.log(error);
                });
            },
            actualizarCliente() {
                
                
                // if (this.validarCliente()) {
                //     return;
                // }
                
                let me = this;
            
                var url= '/cliente/actualizar';
                axios.post(url, {
                    'nombres'  : this.nombres,
                    'apellidos': this.apellidos,
                    'login'    : this.login,
                    'password' : this.password,
                    'empresa'  : this.empresa,
                    'telefono' : this.telefono,
                    'direccion': this.direccion,
                    'email'    : this.email,
                    'id'       : this.idCliente
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarCliente(1, '', 'nombres');

                    iziToast.info({
                            title: 'Exito!',
                            message: 'Se ha actualizado el cliente',
                    });

                }).catch(function(error) {
                    console.log(error);
                });




            },
            activarCliente(id) {
                swal({
                    title: 'Esta seguro de activar este cliente?',
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

                        axios.post('/cliente/activar', {
                            'id': id
                        }).then(function(response) {
                            me.listarCliente(1, '', 'nombres');
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
                    title: 'Esta seguro de desactivar este cliente?',
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

                        axios.post('/cliente/desactivar', {
                            'id': id
                        }).then(function(response) {
                            me.listarCliente(1, '', 'nombres');
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
            eliminarCliente(id) {
                swal({
                    title: 'Esta seguro de eliminar esta cliente?',
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

                        axios.post('/cliente/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarCliente(1, '', 'nombres');
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
                this.errorCliente = 0;
                this.errorMostrarMsjCliente = [];

                if (!this.nombres) this.errorMostrarMsjCliente.push("Debe completar el campo Nombres ");
                if (!this.apellidos) this.errorMostrarMsjCliente.push("Debe completar el campo Apellidos ");
                // if (!this.telefono) this.errorMostrarMsjCliente.push("Debe completar el campo Telefono ");
                // if (!this.login) this.errorMostrarMsjCliente.push("Debe completar el campo Login ");
                // if (!this.password) this.errorMostrarMsjCliente.push("Debe completar el campo Password ");
                //  if (!this.empresa) this.errorMostrarMsjCliente.push("Debe completar el campo Empresa ");
                // if (!this.direccion) this.errorMostrarMsjCliente.push("Debe completar el campo Direccion ");
                // if (!this.email) this.errorMostrarMsjCliente.push("Debe completar el campo Email ");
                //if (!this.estado) this.errorMostrarMsjCliente.push("Debe completar el campo Estado ");
                if (this.errorMostrarMsjCliente.length) this.errorCliente = 1;
                return this.errorCliente;
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.nombres = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "cliente":
                        {
                            switch (accion) {
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Cliente'
                                        this.nombres = '';
                                        this.apellidos = '';
                                        this.login = '';
                                        this.password = '';
                                        this.empresa = '';
                                        this.telefono = '';
                                        this.direccion = '';
                                        this.email = '';
                                        this.estado = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Cliente';
                                        this.tipoAccion = 2;
                                        this.idCliente = data['id'];
                                        this.nombres =   data['nombres'];
                                        this.apellidos = data['apellidos'];
                                        this.login =     data['login'];
                                        this.password =  "";
                                        this.empresa =   data['empresa'];
                                        this.telefono =  data['telefono'];
                                        this.direccion = data['direccion'];
                                        this.email =     data['email'];
                                        // this.estado = data['estado'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarCliente(1, this.buscar, this.criterio);
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