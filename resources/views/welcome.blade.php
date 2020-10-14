<!DOCTYPE html>
<html lang="en">
@include('page.head')
<body>
  <!--sidebar-->
  @livewire('sidebar')
  <!-- / sidebar -->
  <!--nosotros-->
  {{-- @livewire('nosotros') --}}
  <!--/nosotros-->
  <!-- reservaciones -->
  @livewire('reservaciones')
  <!--/ reservaciones -->
  <!-- menu -->
  @livewire('menudia')
  <!--/ menu -->
  <!-- pedidos -->
  @livewire('pedido')
  <!-- / pedidos -->
  <!-- footer -->
  {{-- @livewire('footer') --}}
  <!-- / footer -->
  @include('page.script')
</body>
</html>