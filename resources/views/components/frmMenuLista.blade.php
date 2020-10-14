{{-- plantilla2 --}}
<section id="menu-list" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center marb-35">
          <h1 class="header-h">Menu</h1>
        </div>

        <div class="col-md-12  text-center" id="menu-flters">
          <ul>
            <li><a class="filter active" data-filter=".menu-restaurant">Hoy</a></li>
            {{-- <li><a class="filter" data-filter=".breakfast">Breakfast</a></li>
            <li><a class="filter" data-filter=".lunch">Lunch</a></li>
            <li><a class="filter" data-filter=".dinner">Dinner</a></li> --}}
          </ul>
        </div>

        <div id="menu-wrapper">
          @foreach ($menu as $plato)
            
            <div class="breakfast menu-restaurant">
              <span class="clearfix">
                <a class="menu-title" data-toggle="modal" data-target="#modal-plato{{ $plato->id }}"  data-meal-img="{{ asset($plato->foto) }}">{{ $plato->nombre }}</a>
                <span style="left: 166px; right: 44px;" class="menu-line"></span>
                <span class="menu-price">{{ $plato->precio }} .Bs</span>
              </span>
              <span class="menu-subtitle">{{ $plato->descripcion }}</span>
            </div>


            <div class="modal fade" id="modal-plato{{ $plato->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">


                  <div class="modal-body mb-0 p-0">


                    <div class="form-group row">
                      <label class="col-md-3 p-t-3 form-control-label" for="text-input">
                        <img data-toggle="modal" data-target="#modal1" src="{{ asset($plato->foto) }}" width="200px" height="200px"  alt="Avatar">
                      </label>
                      <div class="col-md-9">
                        sgjhgdhgjhgdsjhgsdjh dhdjkhkdshdkj jdhjkdshkjdshkjds
                      </div>
                    </div>


                    
                  </div>

                  <div class="modal-footer justify-content-center">
                    <span class="mr-4"></span>
                    <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                  </div>

                </div>
              </div>
            </div>
          @endforeach

          
       


      </div>
    </div>
</section>