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
                        <i class="fa fa-align-justify"></i> Productos
                        <button type="button" @click="abrirModal('producto','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="producto">Producto</option>
                                      <option value="categoria">Categoria</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <!-- <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="producto">Nombre</option>
                                      <option value="categoria">Categoria</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>

                                 -->
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Foto</th>
                                    <th>Descripción</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto in arrayProducto" :key="producto.id">
                                 
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.categoria"></td>
                                    <td v-text="producto.precio"></td>
                                    <td><img :src="`${producto.foto}`" width="100px" alt=""></td>
                                    <td v-text="producto.descripcion"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('producto','modificar',producto)" class="btn btn-success btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                         <button type="button" class="btn btn-danger btn-sm" @click="eliminarProducto(producto.id)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idCategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Producto">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Seleccione una imagen</label>
                                    <div class="col-md-9">
                                        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>

                                <div v-show="errorProducto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarProducto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProducto()">Modificar</button>
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
                idProducto: 0,
                idCategoria : 0,
                nombreCategoria : '',
                nombre : '',
                precio : 0,
                foto : '',
                descripcion : '',
                arrayProducto : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProducto : 0,
                errorMostrarMsjProducto : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'producto',
                buscar : '',
                arrayCategoria :[],
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
            listarProducto (page,buscar,criterio){
                let me=this;
                var url= '/producto?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.producto.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            handleFileUpload(){
                this.foto = this.$refs.file.files[0];
            },
            selectCategoria(){
                let me=this;
                var url= '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categoria;
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
                me.listarProducto(page,buscar,criterio);
            },
            guardarProducto(){
                if (this.validarProducto()){
                    return;
                }

                let me = this;
                let url  = '/producto/guardar';
                let header = { headers : {'Content-Type' : 'multipart/form-data'} }
                let data = new FormData();
                    data.append('idCategoria', this.idCategoria)
                    data.append('nombre'     , this.nombre)
                    data.append('foto'       , this.foto)
                    data.append('precio'     , this.precio)
                    data.append('descripcion', this.descripcion)

                axios.post(url,data,header).then(function (response) {
                    console.log('Funcionexitosa')
                    me.cerrarModal();
                    me.listarProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarProducto(){
                //    if (this.validarProducto()){
                //         return;
                //     }
                let url    = '/producto/modificar';

                let header = { headers : {'Content-Type' : 'multipart/form-data'} }
                let data = new FormData();
                    data.append('idCategoria', this.idCategoria)
                    data.append('nombre'     , this.nombre)
                    data.append('id'         , this.idProducto)
                    data.append('foto'       , this.foto)
                    data.append('precio'     , this.precio)
                    data.append('descripcion', this.descripcion)
                
                let me = this;

                axios.post(url,data,header).then(function (response) {
                    me.cerrarModal();
                    me.listarProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });  
            },
            eliminarProducto(id) {
                swal({
                    title: 'Esta seguro de eliminar esta categoria?'+id,
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

                        axios.post('/producto/eliminar', {
                            'id': id
                        }).then(function(response) {
                            me.listarProducto(1, '', 'nombre');
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
            validarProducto(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto =[];

                if (this.idCategoria==0) this.errorMostrarMsjProducto.push("Seleccione una categoría.");
                if (!this.nombre) this.errorMostrarMsjProducto.push("El nombre del artículo no puede estar vacío.");
                // if (!this.foto) this.errorMostrarMsjProducto.push("El foto del artículo debe ser un número y no puede estar vacío.");
                if (!this.precio) this.errorMostrarMsjProducto.push("El precio venta del artículo debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

                return this.errorProducto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idCategoria= 0;
                this.nombreCategoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio = 0;
                this.foto = null;
                this.descripcion = '';
		        this.errorProducto=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "producto":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Producto';
                                this.idCategoria=0;
                                this.nombreCategoria='';
                                this.codigo='';
                                this.nombre= '';
                                this.precio=0;
                                this.foto=null;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'modificar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal    ='Modificar Producto';
                                this.tipoAccion     = 2;
                                this.idProducto     = data['id'];
                                this.idCategoria    = data['idCategoria'];
                                this.codigo         = data['codigo'];
                                this.nombre         = data['nombre'];
                                this.foto           = data['foto'];
                                this.precio         = data['precio'];
                                this.descripcion    = data['descripcion'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            }
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio);
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
