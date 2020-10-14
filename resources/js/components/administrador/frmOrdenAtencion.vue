<template>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Admin</a></li>
        </ol>

        <div class="container-fluid">
            <div class="card">

                <template v-if="detalleActualizar == 1">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>  Mesas : <strong>{{idMesa}}</strong>  -   
                        <img width="30px" height="30px" src="imagenes/icon_mesa_black.png" alt="">
                    </div>
                    
                    <div class="card-body">
                        <div class="">
                            
                        </div>
                        <div class="form-group row border p-2 d-flex justify-content-between align-items-center">
                            <label for="" class="label-items" ><strong>Cliente : </strong>{{nombreCompleto}}</label>
                            <button type="submit" @click="abrirModal('orden','actualizar')" class="btn btn-success btn-sm"><i class="icon-plus"></i> Producto</button>
                        </div>

                        <div class="form-group row border">
                            <div class="centrado"><strong>Orden de Atencion : {{idOrdenAtencion}}</strong> 
                            
                            </div>
                            <div class="table-responsive col-md-12 p-4"  >
                                <table class="table table-bordered table-striped table-sm">
                                    <thead >
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ArrayDetalleOrdenAtencion.length">

                                            <tr v-for="(detalle,index) in ArrayDetalleOrdenAtencion" :key="detalle.idProducto">
                                                <td v-text="detalle.nombre"></td>
                                                <td v-text="detalle.precio"></td>
                                                <td><input type="number" v-model="detalle.cantidad" class="form-control"></td>
                                                <td> {{detalle.precio*detalle.cantidad}} </td>
                                                <td>     
                                                    <button @click="eliminarProductoDetalleOrden(index,detalle.id)" class="btn btn-danger btn-sm">
                                                        <i class="icon-close" ></i>
                                                    </button>
                                                    <button @click="añadirProductoDetalleOrdenAtencion(index,detalle)" class="btn btn-info btn-sm">
                                                        <i class="icon-check" ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total :</strong></td>
                                                <td>
                                                    {{ montoTotalActualizar = (calcularMontoTotalActualizar)  }} .Bs
                                                </td>
                                            </tr>             
                                    </tbody>
                                    <tbody v-else>
                                        <td colspan="5" align="center"><strong>No ha asignado ningun producto</strong></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                         <div class="row border p-2">
                            <button @click="mostrarListaMesa()" class="btn btn-sm btn-secondary">Cerrar</button>
                            &nbsp;
                            <button class="btn btn-sm btn-primary" @click="finalizarOrdenAtencion()">Finalizar</button>
                        </div>
                      

                    </div>
                </template>

                <template v-if="listaMesas==1">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Mesas  -   
                        <img width="30px" height="30px" src="imagenes/icon_mesa_black.png" alt="">
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group row"> 
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-8" v-model="criterio">
                                        <option value="capacidad">Capacidad</option>
                                        <option value="ubicacion">Ubicacion</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarMesas(1,buscar, criterio)" class="form-control" placeholder="Buscar">                                
                                    <button type="submit" @click="listarMesas(1,buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12"> <!--lista--> <br>
                                <div class="row" >
                                    <div v-for="mesa in ArrayMesa" :key="mesa.id" class="col-md-3 col-sm-4 col-auto">
                                        <table  class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <template v-if="mesa.ocupado==1">
                                                        <th class="">
                                                            <div class="card alert-danger" style="width: 100% height:100%" >
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <h6><img width="15px" src="imagenes/persona.png" alt=""> <strong v-text="mesa.capacidad"></strong> </h6> 
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <button type="button" @click="showActualizarDetalle(mesa.id)" class="btn btn-danger btn-sm">
                                                                                        <img width="30px" height="30px" src="imagenes/icono-restaurante.png" alt="">
                                                                            </button> &nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>            
                                                    </template>

                                                    <template v-else>
                                                        <th class="">
                                                            <div class="card alert-info" style="width: 100% height:100%" >
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <h6><img width="15px" src="imagenes/persona.png" alt=""> <strong v-text="mesa.capacidad"></strong> </h6> 
                                                                        </div>
                                                                        <div class="col-md-6">

                                                                            <button type="button" @click="showAgregarDetalle(mesa)" class="btn btn-success btn-sm">
                                                                                        <img width="30px" height="30px" src="imagenes/icono-restaurante.png" alt="">
                                                                            </button> &nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>             
                                                    </template>
                                                </tr>

                                            </thead>

                                        </table>
                                    </div>
                                </div>
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


                        <!--
                        Lista de Mesas
                        <button @click="mostrarDetalleAgregar()" class="btn btn-sm btn-info" type="submit" >Agregar Detalle</button>                        
                        <button @click="mostrarDetalleActualizar()" class="btn btn-sm btn-info" type="submit" >Actualizar Detalle</button>    -->                    
                    </div>
                </template>

                <template v-if="detalleAgregar == 1">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Mesa  -  {{ idMesa }}  
                        <img width="30px" height="30px" src="imagenes/icon_mesa_black.png" alt="">
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label for="">Agregar Cliente</label>
                                    <v-select 
                                        @search="seleccionarCliente"
                                        label="nombreCompleto"
                                        :options="ArrayCliente"
                                        placeholder="Buscar Cliente..."
                                        @input="getCliente"
                                    >
                                    </v-select>  
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lista de Productos</label>
                                    <div class="input-group">
                                    <input type="text" disabled  class="form-control frm-control-sm" placeholder="Añadir una lista">
                                    <button type="submit" @click="abrirModal('orden','agregar')"  class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> </button>
                                </div>                                  
                                </div>
                            </div>
                        </div>

                        <div class="form-group row border" >
                            <div class="table-responsive col-md-12 p-4"  >
                                <table class="table table-bordered table-striped table-sm">
                                    <thead >
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ArrayDetalleAtencion.length">

                                            <tr v-for="(detalle,index) in ArrayDetalleAtencion" :key="detalle.idProducto">
                                                <td v-text="detalle.nombre"></td>
                                                <td v-text="detalle.precio"></td>
                                                <td><input type="number" v-model="detalle.cantidad" class="form-control"></td>
                                                <td> {{detalle.precio*detalle.cantidad}}</td>
                                                <td>     
                                                    <button @click="eliminarProductoDetalle(index)" class=" btn btn-danger btn-sm">
                                                        <i class="icon-close" ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total :</strong></td>
                                                <td>
                                                    {{ montoTotalAgregar = (calcularMontoTotalAgregar)  }} .Bs
                                                </td>
                                            </tr>             
                                    </tbody>
                                    <tbody v-else>
                                        <td colspan="5" align="center"><strong>No ha asignado ningun producto</strong></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                    
                    
                    <div class="card-body">

                        <button  @click="guardarDetalleOrden()" class="btn btn-success">Guardar </button>
                        <button @click="mostrarListaMesa()" class="btn btn-secondary">Cerrar </button>                      
                    </div>
                </template>

            </div>
        </div>

        <div id="modal" class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <template v-if="tipoAccion==1">
                                <div class="form-group row">


                                <!--
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <select class="form-control col-md-6" v-model="criterioProducto">
                                            <option value="nombre">Producto</option>
                                            </select>
                                            <input type="text" v-model="buscarProducto" @keyup.enter="menuProducto(buscarProducto,criterioProducto)" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                            <button type="submit" @click="menuProducto(buscarProducto,criterioProducto)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                aqui
                                -->

                                <div v-for="menu in ArrayMenu" :key="menu.id">
                                    <div class="btn-group-sm p-1">
                                        <button type="submit" @click="menuProducto(menu.id)" class="btn btn-primary">{{menu.categoria}}</button>
                                    </div>
                                </div>

                                    <div class="table-responsive col-md-12 p-4"  >

                                    </div>
                                </div>
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>idProducto</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Foto</th>
                                            <th>Opciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="producto in ArrayMenuProducto" :key="producto.idProducto">
                                        
                                            <td v-text="producto.idProducto"></td>
                                            <td v-text="producto.nombre"></td>
                                            <td v-text="producto.precio"></td>
                                            <td><img :src="`${producto.foto}`" width="100px" alt=""></td>
                                            <td>
                                                <template v-if="tipoAccion==1">
                                                    <button type="button" @click="añadirProductoDetalle(producto)" class="btn btn-success btn-sm">
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </template>

                                                <template v-if="tipoAccion==2">
                                                    <button type="button" @click="agregarArrayActualizar(producto)" class="btn btn-info btn-sm">
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </template>
                                            </td>
                                        </tr>             
                                    </tbody>
                                </table>
                            </template>

                            <template v-if="tipoAccion==2">
                                <div class="form-group row">


                                <!--
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <select class="form-control col-md-6" v-model="criterioProducto">
                                            <option value="nombre">Producto</option>
                                            </select>
                                            <input type="text" v-model="buscarProducto" @keyup.enter="menuProducto(buscarProducto,criterioProducto)" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                            <button type="submit" @click="menuProducto(buscarProducto,criterioProducto)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                aqui
                                -->

                                <div v-for="menu in ArrayMenu" :key="menu.id">
                                    <div class="btn-group-sm p-1">
                                        <button type="submit" @click="menuProducto(menu.id)" class="btn btn-primary">{{menu.categoria}}</button>
                                    </div>
                                </div>

                                    <div class="table-responsive col-md-12 p-4"  >

                                    </div>
                                </div>

                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>idProducto</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Foto</th>
                                            <th>Opciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="producto in ArrayMenuProducto" :key="producto.idProducto">
                                        
                                            <td v-text="producto.idProducto"></td>
                                            <td v-text="producto.nombre"></td>
                                            <td v-text="producto.precio"></td>
                                            <td><img :src="`${producto.foto}`" width="100px" alt=""></td>
                                            <td>

                                                <template v-if="tipoAccion==2">
                                                    <button type="button" @click="agregarProductoDetalleOrden(producto)" class="btn btn-info btn-sm">
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </template>
                                            </td>
                                        </tr>             
                                    </tbody>
                                </table>
                            </template>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>

                </div>

        </div>




    </main>
</template>

<script>
    import vSelect from 'vue-select';
    import vSelect1 from 'vue-select';
    import Datepicker from 'vuejs-datepicker';
    import 'vue-select/dist/vue-select.css';

    export default {
        data() {
            return {
                //Variables de control de vista
                detalleActualizar : 0 ,
                listaMesas : 1,
                detalleAgregar : 0,


                //Orden de atencion
                idOrdenAtencion : 0,



                //Arrays
                ArrayMesa            : [],
                ArrayCliente         : [],
                ArrayMenuProducto    : [],
                ArrayDetalleAtencion : [],
                ArrayMenu            : [],


                // guarda todos los productos ingresados a la DB
                ArrayDetalleOrdenAtencion : [],
            


                //atributos mesa
                idMesa : 0,
                estado  : 'cris',
                ocupado : true,

                //Atributos del cliente
                idCliente : 0,
                nombreCliente :'',
                apellidoCliente:'',
                nombreCompleto : '',

                //Atributos Orden Atencion
                montoTotalAgregar    : 0.0,  
                montoTotalActualizar : 0.0,

                //Parametros de busqueda de las mesas
                criterio : 'capacidad',
                buscar   : '',
                criterioProducto : 'nombre',
                buscarProducto : '',

                //Paginacion
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,


                //Variables del modal
                modal       : 0,
                tituloModal : '',
                tipoAccion  : 0,


                //Variables de validacion
                errorMostrarMsjDetalle : [],
                errorDetalle : 0 
            }
        },
        components:{
            vSelect,
            vSelect1,
            Datepicker
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
            },
            // Calcula el montoTotal al agregar
            calcularMontoTotalAgregar: function(){
                var resultado = 0.0 ;
                for (let index = 0; index < this.ArrayDetalleAtencion.length; index++) {
                    resultado = resultado + (this.ArrayDetalleAtencion[index].precio*this.ArrayDetalleAtencion[index].cantidad);
                }
                return resultado;
            },
            calcularMontoTotalActualizar: function(){
                 var resultado = 0.0 ;
                for (let index = 0; index < this.ArrayDetalleOrdenAtencion.length; index++) {
                    resultado = resultado + (this.ArrayDetalleOrdenAtencion[index].precio*this.ArrayDetalleOrdenAtencion[index].cantidad);
                }
                return resultado;
            },

        },
        methods: {
            //Metdos para controlar la vista de lista y formulario
            mostrarListaMesa(){
                this.listaMesas = 1;
                this.ocultarDetalleAgregar();  
                this.ocultarDetalleActualizar();      
            },
            mostrarDetalleAgregar(){
                this.detalleAgregar = 1;
                this.ocultarListaMesa();
            },
            mostrarDetalleActualizar(){
                this.detalleActualizar = 1;
                this.ocultarListaMesa();
            },
            ocultarListaMesa(){
                this.listaMesas = 0;
            },
            ocultarDetalleAgregar(){
                this.detalleAgregar = 0;
            },
            ocultarDetalleActualizar(){
                this.detalleActualizar = 0;
            },
            
            // Metodo para la paginacion
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarMesas(page, buscar, criterio);
            },
            //Metodo principal
            listarMesas(page,buscar,criterio){
                let me = this;
                var url = '/mesa?page='+ page + '&buscar=' + buscar + '&criterio='+ criterio ;

                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.ArrayMesa = respuesta.mesa.data;
                   me.pagination = respuesta.pagination
                   console.log(me.ArrayMesa);
                }).catch(function(error){
                    console.log(error);
                });
            },
            //Metodos para obtener el cliente
            seleccionarCliente(search,loading){
                 let me=this;
                loading(true);
                var url= '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta   = response.data;
                    me.ArrayCliente = respuesta.clientes;
                    loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getCliente(valor){
                        let me=this;
                        me.loading          = true;
                        me.idCliente        = valor.id;
                        me.nombreCliente    = valor.nombres;
                        me.apellidoCliente  = valor.apellidos;
                        console.log(valor);
                        me.searchProducto = 1;
            },
            
            // Metodos que muestran los formularios de agregar y actualizar
            showAgregarDetalle(mesa){
                this.mostrarDetalleAgregar();
                this.idMesa      = mesa.id;

            },

            showActualizarDetalle(id){
                iziToast.show({
                    title :"mesa numero"+ id
                })  
                this.getDetalleOrden(id);              
                this.mostrarDetalleActualizar();  
            },

            // lista de productos del menu actual
            menuProducto(criterio){
                let me =this;
                var url = '/producto/listaMenuProducto?buscar='+ '&criterio='+ criterio;

                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.ArrayMenuProducto = respuesta.productoMenu;
                    console.log(me.ArrayMenuProducto);
                }).catch(function(error){
                    console.log(error)
                });
            },

            //metodo para añadir el producto desde el modal
            añadirProductoDetalle(data=[]){
                let me = this;
                var existe = me.existeProducto(data["idProducto"]);

                if(existe){
                     iziToast.error({
                                title :"Error!!",
                                message :"El producto ya se encuentra agregado",
                    });
                }else{
                    me.ArrayDetalleAtencion.push({
                                "idProducto" : data['idProducto'],
                                "nombre"     : data['nombre'],
                                "precio"     : data['precio'],
                                "cantidad"   : 1
                    });
                      
                    iziToast.success({
                                title:"agregado correctamente !!"
                    });

                }
            },
            existeProducto(id){
                var sw = false;
                for (let index = 0; index < this.ArrayDetalleAtencion.length; index++) {
                    var productoId = this.ArrayDetalleAtencion[index].idProducto;
                    if(productoId == id){
                        sw = true;
                    }
                }
                return sw;
            },

            //Guarda el detalle 
            guardarDetalleOrden(){
                let me = this;

                var url = '/ordenAtencion/guardar';

                if (this.validarDetalle()){
                    this.mostrarErrorValidacion();
                
                }else{
                    axios.post(url,{
                        'idCliente' : this.idCliente,
                        'data'      :this.ArrayDetalleAtencion,
                        'idMesa'    :this.idMesa
                    }).then(function(response){
                            me.listarMesas(1, '', '');
                            me.mostrarListaMesa()
                            iziToast.info({
                                title: 'Exito!',
                                message: 'La Orden se ha guardado con exito!',
                            });
                        me.resetearVariable();
                    }).catch((errot) => {
                        console.log(error);
                    });
                }
            },
            //Elimina del detalle
            eliminarProductoDetalle(index){
                let me = this;
                me.ArrayDetalleAtencion.splice(index,1);
                iziToast.error({
                    title:'',
                    message: 'Producto eliminado del detalle'
                });

            },

            //Metodos para el modal de productos
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "orden":
                        {
                            switch (accion) {
                                case 'agregar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Seleccionar Producto'
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Cliente';
                                        this.tipoAccion = 2;
                                        break;
                                    }
                            }
                        }
                }
                this.allMenu();
            },
            cerrarModal(){
                
                this.modal=0;
                this.tituloModal='';
                document.getElementsByTagName("html")[0].style.overflow = "auto";

            },

            //Validacion de formulario
            validarDetalle(){
                
                this.errorDetalle=0;
                this.errorMostrarMsjDetalle =[];

                if (this.idCliente==0) this.errorMostrarMsjDetalle.push("Seleccioe un cliente.");
                if (this.ArrayDetalleAtencion.length<=0) this.errorMostrarMsjDetalle.push("Primero ingrese productos");
                return this.errorDetalle;

            },
            mostrarErrorValidacion(){
                 for (let index = 0; index < this.errorMostrarMsjDetalle.length; index++) {
                    
                    iziToast.error({
                        title:'Validacion',
                        message : this.errorMostrarMsjDetalle[index],
                        position: 'center'
                    });
                }
            },
            
            //Obtener el detalle de una mesa
            getDetalleOrden(id){
                
                let me = this;
                var url = '/detalleOrden/buscar?filtro='+id;

                axios.get(url).then(function(response){
                    var respuesta      = response.data;
                    me.idCliente       = respuesta.idCliente;
                    me.idMesa          = respuesta.idMesa;
                    me.idOrdenAtencion = respuesta.idOrdenAtencion;
                    me.nombreCompleto  = respuesta.nombreCompleto;
                    me.ArrayDetalleOrdenAtencion = respuesta.detalle;

                }).catch(function(error){
                    console.log(error);
                });
            },            
            
            // Borrar array y variables
            resetearVariable(){

            },
            //Metodos de eliminacion y actualizacion de Maestro Detalle
            eliminarProductoDetalleOrden(index,id){
                let me = this;
                me.ArrayDetalleOrdenAtencion.splice(index,1);
                var url ='/item/eliminar';
                axios.post(url,{
                    'id' : id
                }).then(function(){
                    iziToast.error({
                        title:'',
                        message: 'Producto eliminado del detalle'
                    });
                }).catch((error) => {
                    console.log(error);
                })
            },
            añadirProductoDetalleOrdenAtencion(index,data=[]){
                let me = this;

                var url = '/item/actualizar';
                axios.post(url,{
                    'id'        : data['id'],
                    'idDetalle' : data['idDetalle'],
                    'cantidad'  : data['cantidad'],
                    'idMesa'    : data['idMesa'],
                    'idOrdenAtencion' : data['idOrdenAtencion'],
                    'idProducto' : data['idProducto'],
                    'precio' : data['precio']
                }).then(() => {
                     iziToast.error({
                        title:'',
                        message: 'Producto actualizado del detalle'
                    });
                }).catch((error) => {
                    console.log(error);
                })
                console.log(data);
            },
            //agrega productos a la DB desde el modal
            agregarProductoDetalleOrden(data=[]){
                let me = this;
                
                if(me.validarProducto(data['idProducto'])){
                     swal(
                            'No Permitido!',
                            'El registro ha sido ingresado anteriormente.',
                            'error'
                    )
                }else{
                        console.log(data);
                        console.log(data['idProducto']);
                        console.log(data['precio']);
                        console.log(this.idOrdenAtencion);

                    var url = '/agregar/producto/detalle';

                    axios.post(url, {
                        'idProducto'     : data['idProducto'],
                        'precio'         : data['precio'],
                        'idOrdenAtencion': this.idOrdenAtencion
                        
                    }).then(function(response) {
                        swal(
                            'Exito!',
                            'El registro ha sido ingresado con éxito.',
                            'success'
                        )
                    }).catch(function(error) {
                        console.log(error);
                    });

                    this.getDetalleOrden(this.idMesa);
                }
                
            
            },
            //valida si el producto existe en el array de detalle en la DB
            validarProducto(idProducto){
                let me = this;
                var sw = false;

                for (let index = 0; index < me.ArrayDetalleOrdenAtencion.length; index++) {
                    var producto = me.ArrayDetalleOrdenAtencion[index].idProducto
                    if(idProducto == producto){
                        sw = true;
                    }
                }

                return sw;
                
            },
            //finaliza la orden de atencion
            finalizarOrdenAtencion(){

                let me = this;

                 swal({
                    title: 'Esta seguro de finalizar la orden?',
                    message: 'Al finalizar la orden ya no podra acceder a ella',
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

                        axios.post('/finalizar/orden', {
                            'idMesa': me.idMesa,
                            'idOrdenAtencion': me.idOrdenAtencion
                        }).then(function(response) {
                            me.listarMesas(1, '', '');
                            swal(
                                'Exito!',
                                'La Orden de Atancion fue finalizada',
                                'success'
                            );
                            me.mostrarListaMesa();
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
            //trae todos los menus de la fecha actual que esten activos
            allMenu(){
                let me =this;
                var url = '/menu/allMenu';

                axios.get(url).then(function(response){
                    var respuesta    = response.data;
                    me.ArrayMenu     = respuesta.menu;
                }).catch(function(error){
                    cons
                });
            }

        },

        mounted() {
            this.listarMesas(1, this.buscar, this.criterio);
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
        background-color: #ef61617a !important;
    }
    
    .div-error {
        display: flex;
        justify-content: center;
    }
    
    .text-error {
        color: rgba(213, 32, 32, 0.475) !important;
        font-weight: bold;
    }

    .card-danger{
        background-color: red ;
        color: white;
        font-size: 1rem;
    }
    .centrado{
        text-align: center;
        background-color: rgb(83, 205, 205);
        width: 100%;
    }
</style>