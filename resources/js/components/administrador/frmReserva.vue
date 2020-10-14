<template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Reservas
                        <button type="button" @click="abrirModal('reserva','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="cliente">Cliente</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarReserva(1,buscar,criterio)" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarReserva(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <!-- <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="reserva">Comensales/option>
                                      <option value="cliente">Cliente</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarReserva(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarReserva(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                 -->
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Comensales</th>
                                    <th>Cliente</th>
                                    <th>Telefono</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Observacion</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="reserva in arrayReserva" :key="reserva.id">
                                 
                                    <td v-text="reserva.comensales"></td>
                                    <td v-text="reserva.nombreCompleto"></td>
                                    <td v-text="reserva.telefono"></td>
                                    <td v-text="reserva.fecha"></td>
                                    <td v-text="reserva.hora"></td>
                                    <td v-text="reserva.observacion"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('reserva','actualizar',reserva)" class="btn btn-success btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                         <button type="button" class="btn btn-danger btn-sm" @click="eliminarReserva(reserva.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Cliente</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idCliente">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="cliente in arrayCliente" :key="cliente.id" :value="cliente.id" v-text="cliente.nombreCompleto"></option>
                                        </select>                                        
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Comensales</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="comensales" class="form-control" placeholder="Cantidad de Comensales">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Telefono">                                        
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fecha" class="form-control" placeholder="Fecha de Reserva">                                        
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Hora</label>
                                    <div class="col-md-9">
                                        <input type="time" v-model="hora" class="form-control" placeholder="Hora de Reserva">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Observacion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="observacion" class="form-control" placeholder="Ingrese Observacion">
                                    </div>
                                </div>

                                <div v-show="errorReserva" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjReserva" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarReserva()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarReserva()">Modificar</button>
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
    // import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                id: 0,
                idCliente : 0,
                nombresCliente : '',
                comensales : '',
                telefono : '',
                fecha : '',
                hora : '',
                observacion : '',
                arrayReserva : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorReserva : 0,
                errorMostrarMsjReserva : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'cliente',
                buscar : '',
                arrayCliente :[],
            }
        },
        components: {
        // 'barcode': VueBarcode
    },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarReserva (page,buscar,criterio){
                let me=this;
                var url= '/reserva?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayReserva = respuesta.reserva.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            handleFileUpload(){
                this.foto = this.$refs.file.files[0];
            },
            selectCliente(){
                let me=this;
                var url= '/cliente/selectCliente';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarReserva(page,buscar,criterio);
            },
            guardarReserva(){
                if (this.validarReserva()){
                    return;
                }

                let me = this;
                let url  = '/reserva/guardar';
                let header = { headers : {'Content-Type' : 'multipart/form-data'} }
                let data = new FormData();
                    data.append('idCliente', this.idCliente)
                    data.append('comensales'     , this.comensales)
                    data.append('telefono'       , this.telefono)
                    data.append('fecha'     , this.fecha)
                    data.append('hora'     , this.hora)
                    data.append('observacion', this.observacion)

                axios.post(url,data,header).then(function (response) {
                    console.log('Funcionexitosa')
                    me.cerrarModal();
                    me.listarReserva(1,'','cliente');
                    iziToast.success({
                            title: 'Exito!',
                            message: 'Se ha registrado una nueva reserva',
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarReserva(){
               if (this.validarReserva()){
                    return;
                }
                let url    = '/reserva/modificar';
                let me = this;

                axios.post(url,{
                    'comensales': this.comensales,
                    'telefono'  : this.telefono,
                    'fecha'     : this.fecha,
                    'hora'      : this.hora,
                    'observacion' : this.observacion,
                    'idCliente' : this.idCliente,
                    'id' : this.id 
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarReserva(1,'','clientes');
                    iziToast.info({
                            title: 'Exito!',
                            message: 'Se ha actualizado la reserva',
                    });

                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            eliminarReserva(id) {
                swal({
                    title: 'Esta seguro de eliminar este cliente?'+id,
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

                        axios.post('/reserva/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarReserva(1, '', 'comensales');
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
            validarReserva(){
                this.errorReserva=0;
                this.errorMostrarMsjReserva =[];

                if (this.idCliente==0) this.errorMostrarMsjReserva.push("Seleccione un cliente.");
                if (!this.comensales) this.errorMostrarMsjReserva.push("El nombre de la reserva no puede estar vacío.");
                if (!this.telefono) this.errorMostrarMsjReserva.push("El telefono no puede estar vacio");
                if (!this.fecha) this.errorMostrarMsjReserva.push("La fecha no puede estar vacio");
                if (!this.hora) this.errorMostrarMsjReserva.push("La hora no puede estar vacio");
                if (!this.observacion) this.errorMostrarMsjReserva.push("La observacion no puede estar vacio");
                if (this.errorMostrarMsjReserva.length) this.errorReserva = 1;

                return this.errorReserva;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idCliente= 0;
                this.nombresCliente = '';
                this.codigo = '';
                this.comensales = '';
                this.telefono = '';
                this.fecha = '';
                this.hora = '';
                this.observacion = '';
		        this.errorResrva=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "reserva":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Reserva';
                                this.idCliente=0;
                                this.nombresCliente='';
                                this.codigo='';
                                this.comensales= '';
                                this.telefono='';
                                this.fecha='';
                                this.hora='';
                                this.observacion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Modificar Reserva';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.idCliente=data['idCliente'];
                                this.codigo=data['codigo'];
                                this.comensales = data['comensales'];
                                this.telefono=data['telefono'];
                                this.fecha=data['fecha'];
                                this.hora=data['hora'];
                                this.observacion= data['observacion'];
                                break;
                            }
                        }
                    }
                }
                this.selectCliente();
            }
        },
        mounted() {
            this.listarReserva(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
