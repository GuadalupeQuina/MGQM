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
                    <i class="fa fa-align-justify"></i> Tipo
                    <button type="button" @click="abrirModal('tipo','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarTipo(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarTipo(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="tipo in arrayTipo" :key="tipo.id">
                                <td v-text="tipo.nombre"></td>
                                <td>
                                    <button type="button" @click="abrirModal('tipo','actualizar',tipo)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminarTipo(tipo.id)">
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
                            <div v-show="errorTipo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjTipo" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTipo()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTipo()">Modificar</button>
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
                idTipo: 0,
                nombre: '',
                arrayTipo: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorTipo: 0,
                errorMostrarMsjTipo: [],
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
            listarTipo(page, buscar, criterio) {
                let me = this;
                var url = '/tipo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayTipo = respuesta.tipo.data;
                        me.pagination = respuesta.pagination;
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarTipo(page, buscar, criterio);
            },
            registrarTipo() {
                if (this.validarTipo()) {
                    return;
                }
                let me = this;
                axios.post('/tipo/guardar', {
                    'nombre': this.nombre,
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarTipo(1, '', 'nombre');
                }).catch(function(error) {
                    console.log(error);
                });
            },
            actualizarTipo() {
                if (this.validarTipo()) {
                    return;
                }
                let me = this;
                axios.put('/tipo/actualizar', {
                    'nombre': this.nombre,
                    'id': this.idTipo
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarTipo(1, '', 'nombre');
                }).catch(function(error) {
                    console.log(error);
                });
            },
            eliminarTipo(id) {
                swal({
                    title: 'Esta seguro de eliminar este tipo?',
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

                        axios.put('/tipo/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarTipo(1, '', 'nombre');
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
            validarTipo() {
                this.errorTipo = 0;
                this.errorMostrarMsjTipo = [];

                if (!this.nombre) this.errorMostrarMsjTipo.push("Debe completar el campo Nombre ");
                if (this.errorMostrarMsjTipo.length) this.errorTipo = 1;
                return this.errorTipo;
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "tipo":
                        {
                            switch (accion) {
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Tipo'
                                        this.nombre = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Actualizar Tipo';
                                        this.tipoAccion = 2;
                                        this.idTipo = data['id'];
                                        this.nombre = data['nombre'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarTipo(1, this.buscar, this.criterio);
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