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
                    <i class="fa fa-align-justify"></i> Bitacora
                   
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="tabla">Tabla</option>
                                <option value="transaccion">Transaccion</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarRegistros(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarRegistros(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Tabla</th>
                                <th>Transaccion</th>
                                <th>ID Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="bitacora in ArrayBitacora" :key="bitacora.id">
                                <td v-text="bitacora.fecha"></td>
                                <td v-text="bitacora.hora"></td>
                                <td v-text="bitacora.tabla"></td>
                                <td v-text="bitacora.transaccion"></td>
                                <td v-text="bitacora.idUsuario"></td>
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
        </div>
    </main>
</template>

<script>
    export default {

        data() {
            return {
                ArrayBitacora : [],
                idBitacora : 0,

                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'tabla',
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
            listarRegistros(page,buscar,criterio){
                let me = this;

                var url ='/bitacora?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then((response) => {
                    var respuesta    = response.data;
                    me.ArrayBitacora = respuesta.bitacora.data
                    me.pagination    =  respuesta.pagination;
                }).catch((value) => {
                    console.log(value);
                });
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarRegistros(page, buscar, criterio);
            },
        },
        mounted() {
            this.listarRegistros(1,this.buscar,this.criterio);
        },
    }
</script>