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
                    <i class="fa fa-align-justify"></i> Repartidor
                    <button type="button" @click="abrirModal('repartidor','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="apellidos">Apellidos</option>
                                <option value="cedulaID">Cedula</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarRepartidor(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarRepartidor(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Login</th>
                                <th>CedulaID</th>
                                <th>Telefono </th>
                                <th>Direccion</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="repartidor in arrayRepartidor" :key="repartidor.id">
                                <td v-text="repartidor.nombre"></td>
                                <td v-text="repartidor.apellidos"></td>
                                <td v-text="repartidor.login"></td>
                                <td v-text="repartidor.cedulaID"></td>
                                <td v-text="repartidor.telefono"></td>
                                <td v-text="repartidor.direccion"></td>
                                <td>
                                    <button type="button" @click="abrirModal('repartidor','actualizar',repartidor)" class="btn btn-success btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminarRepartidor(repartidor.id)">
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
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre">
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
                                <label class="col-md-3 form-control-label" for="text-input">CedulaID</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cedulaID" class="form-control" placeholder="CedulaID">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Direccion">
                                </div>
                            </div>
                            <div v-show="errorRepartidor" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjRepartidor" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRepartidor()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRepartidor()">Modificar</button>
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
                idRepartidor: 0,
                nombre: '',
                apellidos: '',
                login: '',
                email:'',
                password: '',
                cedulaID: '',
                telefono: '',
                direccion: '',
                arrayRepartidor: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorRepartidor: 0,
                errorMostrarMsjRepartidor: [],
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
            listarRepartidor(page, buscar, criterio) {
                let me = this;
                var url = '/repartidor?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRepartidor = respuesta.repartidor.data;
                        me.pagination = respuesta.pagination;
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarRepartidor(page, buscar, criterio);
            },
            registrarRepartidor() {
                if (this.validarRepartidor()) {
                    return;
                }
                let me = this;
                axios.post('/repartidor/guardar', {
                    'nombre': this.nombre,
                    'apellidos': this.apellidos,
                    'login': this.login,
                    'password': this.password,
                    'cedulaID': this.cedulaID,
                    'telefono': this.telefono,
                    'email': this.email,
                    'direccion': this.direccion,
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarRepartidor(1, '', 'nombre');
                    iziToast.success({
                            title: 'Exito!',
                            message: 'Se ha registrado un nuevo repartidor',
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            },
            actualizarRepartidor() {
                if (this.validarRepartidor()) {
                    return;
                }
                let me = this;
                axios.post('/repartidor/actualizar', {
                    'nombre': this.nombre,
                    'apellidos': this.apellidos,
                    'login': this.login,
                    'password': this.password,
                    'cedulaID': this.cedulaID,
                    'telefono': this.telefono,
                    'email': this.email,
                    'direccion': this.direccion,
                    'id': this.idRepartidor

                }).then(function(response) {
                    me.cerrarModal();
                    me.listarRepartidor(1, '', 'nombre');
                    iziToast.success({
                            title: 'Exito!',
                            message: 'Se ha actualizado el repartidor',
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            },
            eliminarRepartidor(id) {
                swal({
                    title: 'Esta seguro de eliminar este repartidor?',
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

                        axios.post('/repartidor/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarRepartidor(1, '', 'nombre');
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
            validarRepartidor() {
                
                this.errorRepartidor = 0;
                this.errorMostrarMsjRepartidor = [];

                if (!this.nombre) this.errorMostrarMsjRepartidor.push("Debe completar el campo Nombre");
                if (!this.apellidos) this.errorMostrarMsjRepartidor.push("Debe completar el campo Apellidos ");    
                if (!this.login) this.errorMostrarMsjRepartidor.push("Debe completar el campo Login ");
                if (!this.password) this.errorMostrarMsjRepartidor.push("Debe completar el campo Password ");
                if (!this.cedulaID) this.errorMostrarMsjRepartidor.push("Debe completar el campo CedulaID ");
                if (!this.telefono) this.errorMostrarMsjRepartidor.push("Debe completar el campo Telefono ");
                if (!this.direccion) this.errorMostrarMsjRepartidor.push("Debe completar el campo Direccion ");
                if (this.errorMostrarMsjRepartidor.length) this.errorRepartidor = 1;
                return this.errorRepartidor;
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "repartidor":
                        {
                            switch (accion) {
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Repartidor'
                                        this.nombre = '';
                                        this.apellidos = '';
                                        this.login = '';
                                        this.password = '';
                                        this.cedulaID = '';
                                        this.telefono = '';
                                        this.direccion = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Repartidor';
                                        this.tipoAccion = 2;
                                        this.idRepartidor = data['id'];
                                        this.nombre = data['nombre'];
                                        this.apellidos = data['apellidos'];
                                        this.login = data['login'];
                                        this.password = "";
                                        this.cedulaID = data['cedulaID'];
                                        this.telefono = data['telefono'];
                                        this.email = data['email'];
                                        this.direccion = data['direccion'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarRepartidor(1, this.buscar, this.criterio);
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