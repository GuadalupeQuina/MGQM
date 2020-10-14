 @extends('index')
@section('contenido')
    @role('administrador')
        <template v-if="menu==0">
            Modulo de Dashboard
        </template>
        <template v-if="menu==1">
            <frm-administrador-cliente></frm-administrador-cliente>
        </template>
        <template v-if="menu==2">
            <frm-administrador-reserva></frm-administrador-reserva>
        </template>
        <template v-if="menu==3">
            Modulo de Pedidos
        </template>
        <template v-if="menu==4">
            <frm-administrador-orden></frm-administrador-orden>
        </template>
        <template v-if="menu==5">
            <frm-administrador-menu></frm-administrador-menu>
        </template>
        <template v-if="menu==6">
            <frm-administrador-categoria></frm-administrador-categoria>
        </template>
        <template v-if="menu==7">
            <frm-administrador-producto></frm-administrador-producto>
        </template>
        <template v-if="menu==8">
           <frm-administrador-repartidor></frm-administrador-repartidor>
        </template>
        <template v-if="menu==9">
            <frm-administrador-vehiculo></frm-administrador-vehiculo>
        </template>
        <template v-if="menu==10">
            <frm-administrador-usuario></frm-administrador-usuario>  
        </template>
        <template v-if="menu==11">
            <frm-administrador-bitacora></frm-administrador-bitacora>
        </template>
        <template v-if="menu==12">
            Modulo de Reporte
        </template>
        <template v-if="menu==13">
            <frm-administrador-mesa></frm-administrador-mesa>
        </template>
        <template v-if="menu==14">
            <frm-administrador-rol></frm-administrador-rol>
        </template>
    @endrole
    @role('cliente')
        <template v-if="menu==0">
            Modulo de Dashboard
        </template>

        <template v-if="menu==2">
            <frm-cliente-reserva></frm-administrador-reserva>
        </template>
        <template v-if="menu==3">
            Modulo de Pedidos
        </template>
        <template v-if="menu==5">
            <frm-cliente-menu></frm-cliente-menu>
        </template>

        <template v-if="menu==6">
            <frm-administrador-categoria></frm-administrador-categoria>
        </template>

        <template v-if="menu==7">
            <frm-administrador-producto></frm-administrador-producto>
        </template>
    @endrole
    
    @role('repartidor')
        <template v-if="menu==0">
            Modulo de Dashboard
        </template>
        <template v-if="menu==3">
            Modulo de Pedidos
        </template>

        <template v-if="menu==8">
        <frm-administrador-repartidor></frm-administrador-repartidor>
        </template>
        <template v-if="menu==9">
            <frm-administrador-vehiculo></frm-administrador-vehiculo>
        </template>

    @endrole
@endsection