/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Install BootstrapVue
// Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
// Vue.use(IconsPlugin)


// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

// importar  './custom.scss'

// import './custom.scss'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/administrador/ExampleComponent.vue').default);
Vue.component('frm-administrador-categoria', require('./components/administrador/frmCategoria.vue').default);
Vue.component('frm-administrador-repartidor', require('./components/administrador/frmRepartidor.vue').default);
Vue.component('frm-administrador-reserva', require('./components/administrador/frmReserva.vue').default);
Vue.component('frm-administrador-cliente', require('./components/administrador/frmCliente.vue').default);
Vue.component('frm-administrador-tipo', require('./components/administrador/frmTipo.vue').default);
Vue.component('frm-administrador-producto', require('./components/administrador/frmProducto.vue').default);
Vue.component('frm-administrador-mesa', require('./components/administrador/frmMesa.vue').default);
Vue.component('frm-administrador-vehiculo', require('./components/administrador/frmVehiculo.vue').default);
Vue.component('frm-administrador-orden', require('./components/administrador/frmOrdenAtencion.vue').default);
Vue.component('frm-administrador-menu', require('./components/administrador/frmMenu.vue').default);

Vue.component('frm-administrador-rol', require('./components/administrador/frmRoles.vue').default);
Vue.component('frm-administrador-usuario', require('./components/administrador/frmUsuario.vue').default);
Vue.component('frm-administrador-detalle', require('./components/administrador/frmDetalle.vue').default);
Vue.component('frm-administrador-bitacora', require('./components/administrador/frmBitacora.vue').default);


Vue.component('frm-cliente-reserva', require('./components/cliente/frmReserva').default);
Vue.component('frm-cliente-menu',require('./components/cliente/frmMenu').default);


const app = new Vue({
    el: '#app',
    data:{
        menu:0
    }
});

// const page = new Vue({
//     el: '#page',
//     data:{
//         menu:0
//     }
// });
