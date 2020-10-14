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
                    <i class="fa fa-align-justify"></i> Mesa
                    <button type="button" @click="abrirModal('mesa','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-5" v-model="criterio">
                                <option value="capacidad">Capacidad</option>
                                <option value="ubicacion">Ubicacion</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarMesa(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarMesa(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Capacidad</th>
                                <th>Descripcion</th>
                                <th>Ubicacion</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="mesa in arrayMesa" :key="mesa.id">
                                <td v-text="mesa.capacidad"></td>
                                <td v-text="mesa.descripcion"></td>
                                <td v-text="mesa.ubicacion"></td>
                                <td>
                                    <div v-if="mesa.ocupado==1">
                                        <span class="badge badge-danger">Ocupado</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-success">Libre</span>

                                    </div>
                                </td>
                                 <td>
                                    
                                    <button type="button" @click="abrirModal('mesa','actualizar',mesa)" class="btn btn-success btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                        <button type="mesa" class="btn btn-danger btn-sm" @click="eliminarMesa(mesa.id)">
                                            <i class="icon-trash"></i>
                                        </button> &nbsp;
                                        
                                        
                                        
                                     <!--   <template v-if="mesa.ocupado==0">
                                            <button type="button" class="btn btn-warning btn-sm" @click="ocupadoMesa(mesa.id)">
                                                <i class="fa fa-unlock"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-danger btn-sm" @click="desocupadoMesa(mesa.id)">
                                                <i class="fa fa-lock"></i>
                                            </button>
                                        </template>  -->    
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

                                <label class="col-md-3 form-control-label" for="text-input">Capacidad</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="capacidad" class="form-control" placeholder="Capacidad">
                                </div>

                            </div>

                            <div class="form-group row">


                                <label class="col-md-3 form-control-label" for="text-input">Ubicacion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ubicacion" class="form-control" placeholder="Ubicacion">
                                </div>

                            </div>


                            <div class="form-group row">

                                <label class="col-md-3 form-control-label" for="text-input">Descripcion</label>
                                <div class="col-md-9">
                                    <textarea v-model="descripcion" id="" class="form-control" cols="90" rows="5"></textarea>
                                    <!-- <input type="text"  class="form-control" placeholder="Capacidad"> -->
                                </div>

                            </div>
                            <div v-show="errorMesa" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjMesa" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarMesa()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarMesa()">Modificar</button>
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
                idMesa: 0,
                capacidad: 0,
                descripcion: '',
                ubicacion: '',
                ocupado: true,
                arrayMesa: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorMesa: 0,
                errorMostrarMsjMesa: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'capacidad',
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
            listarMesa(page, buscar, criterio) {
                let me = this;
                var url = '/mesa?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayMesa = respuesta.mesa.data;
                        me.pagination = respuesta.pagination;
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarMesa(page, buscar, criterio);
            },
            registrarMesa() {
                if (this.validarMesa()) {
                    return;
                }
                let me  = this;
                let url = '/mesa/guardar';

                let data = new FormData();
                data.append('capacidad', this.capacidad);
                data.append('descripcion', this.descripcion);
                data.append('ubicacion', this.ubicacion);
                data.append('ocupado', this.ocupado);

                axios.post(url,data).then(function(response) {
                    me.cerrarModal();
                    me.listarMesa(1, '', 'nombre');
                      iziToast.success({
                            title: 'Exito!',
                            message: 'Se ha registrado una nueva mesa',
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            },
            actualizarMesa() {
                if (this.validarMesa()) {
                    return;
                }
                let me = this;
                let url = '/mesa/modificar';
                
                let data = new FormData();
                data.append('capacidad',   this.capacidad);
                data.append('descripcion', this.descripcion);
                data.append('ubicacion',   this.ubicacion);
                data.append('ocupado',     this.ocupado);
                data.append('id',          this.idMesa);

                axios.post(url,data).then(function(response) {
                    me.cerrarModal();
                    me.listarMesa(1, '', 'nombre');
                    iziToast.info({
                            title: 'Exito!',
                            message: 'Se ha actualizado la mesa',
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            },
            eliminarMesa(id) {
                swal({
                    title: 'Esta seguro de eliminar esta mesa?',
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

                        axios.post('/mesa/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarMesa(1, '', 'descripcion');
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
            desocupadoMesa(id){
                swal({
                title: 'Se va a desocupar esta mesa?',
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

                    axios.post('mesa/libre',{
                        'id': id
                    }).then(function (response) {
                        me.listarMesa(1, '', 'descripcion');
                        swal(
                        'Desocupada!',
                        'La mesa esta Desocupada.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            ocupadoMesa(id){
                swal({
                title: 'Se va a ocupar esta Mesa?',
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

                    axios.post('mesa/ocupado',{
                        'id': id
                    }).then(function (response) {
                        me.listarMesa(1, '', 'capacidad');
                        swal(
                        'Ocupada!',
                        'La Mesa esta Ocupada.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },

            validarMesa() {
                this.errorMesa = 0;
                this.errorMostrarMsjMesa = [];

                if (!this.capacidad) this.errorMostrarMsjMesa.push("Debe completar el campo Nombre ");
                if (this.errorMostrarMsjMesa.length) this.errorMesa = 1;
                return this.errorMesa;
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.capacidad = 0;
                this.descripcion = '';
                this.ubicacion = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "mesa":
                        {
                            switch (accion) {
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Guardar Mesa'
                                        this.capacidad = 0;
                                        this.ubicacion = '';
                                        this.descripcion = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Mesa';
                                        this.tipoAccion = 2;
                                        this.idMesa =       data['id'];
                                        this.ocupacion =    data['ocupacion'];
                                        this.capacidad =    data['capacidad'];
                                        this.descripcion =  data['descripcion'];
                                        this.ubicacion =    data['ubicacion'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarMesa(1, this.buscar, this.criterio);
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