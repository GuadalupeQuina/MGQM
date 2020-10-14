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
                        <i class="fa fa-align-justify"></i> Vehiculos
                        <button type="button" @click="abrirModal('vehiculo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="vehiculo">Vehiculo</option>
                                      <option value="repartidor">Repartidor</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarVehiculo(1,buscar,criterio)" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarVehiculo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <!-- <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="vehiculo">TipoVehiculo/option>
                                      <option value="repartidor">Repartidor</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarVehiculo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarVehiculo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                 -->
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Vehiculo</th>
                                     <th>Repartidor</th>
                                    <th>Caracteristicas</th>
                                    <th>Placa</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="vehiculo in arrayVehiculo" :key="vehiculo.id">
                                 
                                    <td v-text="vehiculo.tipoVehiculo"></td>
                                    <td v-text="vehiculo.repartidor"></td>
                                    <td v-text="vehiculo.caracteristicas"></td>
                                    <td v-text="vehiculo.placa"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('vehiculo','actualizar',vehiculo)" class="btn btn-success btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                         <button type="button" class="btn btn-danger btn-sm" @click="eliminarVehiculo(vehiculo.id)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Repartidor</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idRepartidor">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="repartidor in arrayRepartidor" :key="repartidor.id" :value="repartidor.id" v-text="repartidor.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Vehiculo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tipoVehiculo" class="form-control" placeholder="Tipo Vehiculo de Vehiculo">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Caracteristicas</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="caracteristicas" class="form-control" placeholder="Caracteristicas de Vehiculo">                                        
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Placa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="placa" class="form-control" placeholder="Placa de Vehiculo">                                        
                                    </div>
                                </div>
                                <div v-show="errorVehiculo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjVehiculo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarVehiculo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarVehiculo()  ">Modificar</button>
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
                idRepartidor : 0,
                nombreRepartidor : '',
                tipoVehiculo : '',
                caracteristicas : '',
                placa : '',
                arrayVehiculo: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVehiculo : 0,
                errorMostrarMsjVehiculo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'vehiculo',
                buscar : '',
                arrayRepartidor :[],
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
            listarVehiculo (page,buscar,criterio){
                let me=this;
                var url= '/vehiculo?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVehiculo = respuesta.vehiculo.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            handleFileUpload(){
                this.foto = this.$refs.file.files[0];
            },
            selectRepartidor(){
                let me=this;
                var url= '/repartidor/selectRepartidor';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayRepartidor = respuesta.repartidor;
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
                me.listarVehiculo(page,buscar,criterio);
            },
            guardarVehiculo(){
                if (this.validarVehiculo()){
                    return;
                }

                let me = this;
                let url  = '/vehiculo/guardar';
                let header = { headers : {'Content-Type' : 'multipart/form-data'} }
                let data = new FormData();
                    data.append('idRepartidor', this.idRepartidor)
                    data.append('tipoVehiculo'     , this.tipoVehiculo)
                    data.append('caracteristicas'       , this.caracteristicas)
                    data.append('placa'     , this.placa)

                axios.post(url,data,header).then(function (response) {
                    console.log('Funcionexitosa')
                    me.cerrarModal();
                    me.listarVehiculo(1,'','vehiculo');
                    iziToast.success({
                            title: 'Exito!',
                            message: 'Se ha registrado un nuevo vehiculo',
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarVehiculo(){
               if (this.validarVehiculo()){
                    return;
                }
                let url    = '/vehiculo/modificar';
                let header = { headers : {'Content-Tipe' : 'multipart/form-data' }}
                let data   = new FormData();
                data.append('idRepartidor',this.idRepartidor);
                data.append('tipoVehiculo'     ,this.tipoVehiculo);
                data.append('caracteristicas'       ,this.caracteristicas);
                data.append('placa'       ,this.placa);
                data.append('id'     ,this.id);

                let me = this;

                axios.post(url,data,header).then(function (response) {
                    me.cerrarModal();
                    me.listarVehiculo(1,'','vehiculo');
                     iziToast.info({
                            title: 'Exito!',
                            message: 'Se ha actualizado el vehiculo',
                    });

                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            eliminarVehiculo(id) {
                swal({
                    title: 'Esta seguro de eliminar este repartidor?'+id,
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

                        axios.post('/vehiculo/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarVehiculo(1, '', 'tipoVehiculo');
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
            validarVehiculo(){
                this.errorVehiculo=0;
                this.errorMostrarMsjVehiculo =[];

                if (this.idRepartidor==0) this.errorMostrarMsjVehiculo.push("Seleccione un repartidor.");
                if (!this.tipoVehiculo) this.errorMostrarMsjVehiculo.push("El tipoVehiculo de la reserva no puede estar vacío.");
                if (!this.caracteristicas) this.errorMostrarMsjVehiculo.push("La caracteristicas no puede estar vacio");
                if (!this.placa) this.errorMostrarMsjVehiculo.push("La placa no puede estar vacio");
                if (this.errorMostrarMsjVehiculo.length) this.errorVehiculo = 1;

                return this.errorVehiculo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idRepartidor= 0;
                this.nombreRepartidor = '';
                this.codigo = '';
                this.tipoVehiculo = '';
                this.caracteristicas = '';
                this.placa = '';
		        this.errorVehiculo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "vehiculo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Vehiculo';
                                this.idRepartidor=0;
                                this.nombreRepartidor='';
                                this.codigo='';
                                this.tipoVehiculo= '';
                                this.caracteristicas='';
                                this.placa='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Modificar Vehiculo';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.idRepartidor=data['idRepartidor'];
                                this.codigo=data['codigo'];
                                this.tipoVehiculo = data['tipoVehiculo'];
                                this.caracteristicas=data['caracteristicas'];
                                this.placa=data['placa'];
                                break;
                            }
                        }
                    }
                }
                this.selectRepartidor();
            }
        },
        mounted() {
            this.listarVehiculo(1,this.buscar,this.criterio);
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
