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
                    <i class="fa fa-align-justify"></i> Roles

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <!--<div class="input-group">
                                <select class="form-control col-md-5" v-model="criterio">
                                <option value="capacidad">Capacidad</option>
                                <option value="ubicacion">Ubicacion</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarMesa(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarMesa(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>-->
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="rol in arrayRol" :key="rol.id">
                                <td v-text="rol.name">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
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
                arrayRol: [],
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
            listarRol() {
                let me = this;
                var url = '/rol';
                
                
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRol = respuesta.rol;
                        // me.pagination = respuesta.pagination;
                        console.log(response);
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
        },
        mounted() {
            this.listarRol();
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