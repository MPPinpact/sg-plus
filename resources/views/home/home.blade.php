@extends('home.index')
@section('content')

	<div class="row">
    <div class="col-sm-12 p-0">
      <div class="main-header">
        <h4>Dashboard</h4>
      </div>
    </div>
  </div>

  <!-- 1-1 blocks row start -->
  <div class="row">
    <div class="col-lg-3">
      <div class="card dashboard-card-sm">
        <div class="card-header">
            <h5 class="card-header-text">Total Venta del día</h5>
        </div>
        <div class="card-block">
          <div class="media d-flex">
            <div class="mr-3">
              <div class="new-orders">
                <i class="icofont icofont-cur-dollar bg-success"></i>
              </div>
            </div>
            <div class="media-body">
                <span class="counter-txt f-w-600 f-20">
                  $  <span class="counter" id="totalVentaDia">00.000.000.-</span>
                  <h6 id="VentaDiaLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                </span>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card dashboard-card-sm">
         <div class="card-header">
            <h5 class="card-header-text"  id="totaSemana">Venta acumlada esta Semana</h5>
          </div>
        <div class="card-block">
          <div class="media d-flex order-counter">
            <div class="mr-3">
              <div class="new-orders">
                <i class="icofont icofont-cur-dollar bg-warning"></i>
              </div>
            </div>
            <div class="media-body">
                <span class="counter-txt f-w-600 f-20">
                  $  <span class="counter" id="totalVentaSemana">00.000.000.-</span>
                  <h6 id="VentaSemanaLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                </span>
            </div>
          </div>
          <ul>
            <li class="new-users">

            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
          <div class="card-header">
            <h5 class="card-header-text" id="totalMes">Total Venta Mes EFMAMJJASOND</h5>
          </div>

        <div class="card-block">
          <div class="media d-flex order-counter">
            <div class="mr-3">
              <div class="new-orders">
                <i class="icofont icofont-cur-dollar"></i>
              </div>
            </div>
            <div class="media-body">
                <span class="counter-txt">
                  $  <span class="counter" id="totalVentaMes">00.000.000.-</span>
                  <h6 id="VentaMesLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                </span>
            </div>
          </div>
          <ul>
            <li class="new-users"></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
          <div class="card-header">
            <h5 class="card-header-text" id="totalAgno">Total Venta Año 2000/h5>
          </div>

        <div class="card-block">
          <div class="media d-flex order-counter">
            <div class="mr-3">
              <div class="new-orders">
                <i class="icofont icofont-cur-dollar bg-danger"></i>
              </div>
            </div>
            <div class="media-body">
                <span class="counter-txt">
                  $  <span class="counter" id="totalVentaAgno">00.000.000.-</span>
                  <h6 id="VentaAgnoLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                </span>
            </div>
          </div>
          <ul>
            <li class="new-users"></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- 1-1-blocks row end -->

  <div class="row">
      <div class="col-xl-8 col-lg-12">
          <div class="card">
              <div class="card-block">
                  <h5>Score Vendedores</h5>
                  <div class="table-responsive">
                      <table class="table m-b-0 photo-table" id="tablaScoreVendedores">
                          <thead>
                          <tr class="text-uppercase">
                              <th>Photo</th>
                              <th>Vendedor</th>
                              <th>Meta</th>
                              <th>Ventas</th>
                              <th>%</th>
                          </tr>
                          </thead>
                          <tbody id="tablaScoreVendedoresBody">
                          <tr>
                              <th>
                                  <img class="img-fluid rounded-circle" src="assets/images/avatar-2.png" alt="User">
                              </th>
                              <td>Juan Perez Zapata
                                  <p><i class="icofont icofont-clock-time"></i>Created 14.9.2016</p>
                              </td>
                              <td>$100.000</td>
                              <td>$50.000</td>
                              <td class="chart"> 
                              </td>
                          </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-xl-4 col-sm-12 grid-item">
        <div class="row">
          <div class="col-sm-6">
            <div class="basic-widget basic-widget-purple">
              <a href="{{ route('ptovta') }}" class="waves-effect" >
                <i class="icon-calculator"></i>
                <h5>Punto Venta</h5>
                <div class="counter-txt">
                  <h4 class="counter-txt counter"></h4>
                </div>
              </a>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="basic-widget basic-widget-green">
              <a href="{{ route('cajaDiariaResumen') }}" class="waves-effect" >
              <i class="icofont icofont-coins"></i>
              <h5>Caja Diaria</h5>
              <div class="counter-txt">
                <h4 class="counter"></h4>
              </div>
            </a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="basic-widget basic-widget-orange">
              <a href="{{ route('clientes') }}" class="waves-effect" >
              <i class="icofont icofont-id-card"></i>
              <h5>Clientes</h5>
              <div class="counter-txt">
                <h4 class="counter"></h4>
              </div>
            </a>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="basic-widget basic-widget-pink goShortcut" data-datac="compras">
               <a href="{{ route('compraMasivaList') }}" class="waves-effect" >
              <i class="icofont icofont-listing-number"></i>
              <h5>Compras</h5>
               <div class="counter-txt">
                <h4 class="counter"></h4>
              </div>
            </a>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!-- 2nd row start -->
  <div class="row">
    <!-- 1 col start -->
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-header-text">Busqueda rápida de Productos/Stock/Bodegas</h5>
        </div>
        <div class="card-block">
          {!! Form::open(['id'=>'FormBusquedaProducto','autocomplete' => 'off']) !!}
            <div class="row" >
              <div class="col-md-8">
                <div class="md-input-wrapper">
                  <input id="NombreProductoBusquedaRapida" name="NombreProductoBusquedaRapida" type="text" class="md-form-control md-static" maxlength="250" />
                  <label for="NombreProductoBusquedaRapida">Código/Nombre/Descripción del Producto</label>
                </div>
              </div>

              <div class="col-md-4">
                <button id="botonBuscarProducto" name="botonBuscarProducto" type="button" class="btn btn-success waves-effect waves-light btn-block">
                  Buscar Producto  <i class="icofont icofont-search"></i>
                </button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- 1 col end -->

    <!-- 2 col start -->
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-header-text">Busqueda Rápida de Clientes/Deuda/Cupo</h5>
        </div>
        <div class="card-block">
          {!! Form::open(['id'=>'FormBusquedaCliente','autocomplete' => 'off']) !!}
            <div class="row" >
              <div class="col-md-8">
                <div class="md-input-wrapper">
                  <input id="NombreClienteBusquedaRapida" name="NombreClienteBusquedaRapida" type="text" class="md-form-control md-static" maxlength="250" />
                  <label for="NombreClienteBusquedaRapida">Código/Nombre/RUT</label>
                </div>
              </div>

              <div class="col-md-4">
                <button id="botonBuscarCliente" name="botonBuscarCliente" type="button" class="btn btn-success waves-effect waves-light btn-block">
                  Buscar Cliente  <i class="icofont icofont-search"></i>
                </button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- 2 col end -->
  </div>
  <!-- 2nd row end -->

<!--Modal Buscar Producto -->
<div class="modal fade" id="ModalBuscarProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h6 id="spanTituloModalBusquedaProducto" class="modal-title"></h6>
            </div>
            <div class="modal-body">
        {!! Form::open(['id'=>'FormBusquedaProducto','autocomplete' => 'off']) !!}
          
          <div class="row" >
            <div class="col-md-9">
              <div class="md-input-wrapper">
                <input id="InfoProducto" name="InfoProducto" type="text" class="md-form-control md-static" maxlength="250" />
                <label for="InfoProducto">Código/Nombre/Descripción del Producto</label>
              </div>
            </div>
            <div class="col-md-3">
              <button id="botonBuscar" name="botonBuscar" type="button" class="btn btn-success waves-effect waves-light btn-block">
                Buscar Producto  <i class="icofont icofont-search"></i>
              </button>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="clearfix">
                <h3 tabindex="-1" class="title"> Productos Similares</h3>

                <table id="tablaResultadoBusquedaProducto" class="table table-striped table-hover" cellspacing="0" width="100%"></table>
                
              </div> 
            </div>
          </div>
          <br />
            
          <div class="row" id="">
            <div class="col-md-12">
              <button id="cancelarBPS" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
                Cerrar
              </button>
            </div>
          </div>  
        {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!--Modal STOCK Producto -->
<div class="modal fade" id="ModalStockProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          {!! Form::open(['id'=>'FormStockProducto','autocomplete' => 'off']) !!}
          <input type="hidden" name="IdProductoStock" id="IdProductoStock">
                    
          <div class="row">
            <div class="col-md-12">
              <center><h3 id="NombreProductoStock" tabindex="-1" class="title current"> Stock del Producto</h3></center>
              <table id="tablaStockProducto" class="table table-striped table-hover" cellspacing="0" width="100%"></table>
            </div> 
          </div>
                    
          <div class="row">
            <div class="col-md-4">
              <button id="cerrarBodegaDestino" name="cerrarBodegaDestino" type="button" class="btn-lg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
                Cerrar
              </button>
            </div>            
          </div>  

          {!! Form::close() !!}
        </div>
      </div>
    </div>
</div>
@endsection
