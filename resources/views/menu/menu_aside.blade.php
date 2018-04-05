@php  
  $data = Session::get('perfiles');
  $nroPerfiles = Session::get('nroPerfiles');
  $avatarUser = Auth::user()->usrUrlimage;
  (strlen($avatarUser) > 10) ? $avatar=$avatarUser : $avatar="img/default.jpg";
@endphp
  <section class="sidebar" id="sidebar-scroll">
    <div class="user-panel">
      <div class="f-left image"><img src="{{ asset($avatar) }}" alt="User Image" class="rounded-circle">
      </div>
      <div class="f-left info">
        @if (isset($data))
          @if (strlen($data['v_detalle'][0]->usrNombreFull)>1)
            <span>
              <p>{{$data['v_detalle'][0]->usrNombreFull}}</p>
            </span>
          @endif
        @endif
      </div>
    </div>
    <ul class="sidebar-menu">
      <li class="treeview">
        <a href="#">
          <i class="icon-speedometer"></i><span>  Dashboard </span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="icofont icofont-company"></i><span>Ventas</span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>  
            <a class="waves-effect" href="{{ route('preventas') }}">
              <i class="icon-arrow-right"></i>
             Preventa
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('ventas') }}">
              <i class="icon-arrow-right"></i>
             Venta
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="icofont icofont-company"></i><span>Clientes </span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect" href="{{ route('clientes') }}">
              <i class="icon-arrow-right"></i>
              Clientes
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="icofont icofont-company"></i><span>Crédito </span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect" href="{{ route('cicloFacturacion') }}">
              <i class="icon-arrow-right"></i>
              Ciclos de facturación
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('credito') }}">
              <i class="icon-arrow-right"></i>
              Preferencia de Credito
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('ventaCredito') }}">
              <i class="icon-arrow-right"></i>
              Venta Credito
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="icofont icofont-company"></i><span>Productos </span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect" href="{{ route('umedidas') }}">
              <i class="icon-arrow-right"></i>
              Unidad de medida
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('familias') }}">
              <i class="icon-arrow-right"></i>
              Familias
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('subfamilias') }}">
              <i class="icon-arrow-right"></i>
              Subfamilias
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('impuestos') }}">
              <i class="icon-arrow-right"></i>
              Impuestos
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('productos') }}">
              <i class="icon-arrow-right"></i>
              Productos
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="icofont icofont-company"></i><span>Compras</span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect" href="{{ route('proveedores') }}">
              <i class="icon-arrow-right"></i>
              Proveedores
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('compras') }}">
              <i class="icon-arrow-right"></i>
              Compras
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="icofont icofont-company"></i><span>Administración </span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect" href="{{ route('usuarios') }}">
              <i class="icon-arrow-right"></i>
              Usuarios
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('empresas') }}">
              <i class="icon-arrow-right"></i>
              Empresas
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('locales') }}">
              <i class="icon-arrow-right"></i>
              Locales
            </a>
          </li>
          <li>
            <a class="waves-effect" href="{{ route('bodegas') }}">
              <i class="icon-arrow-right"></i>
              Bodegas
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </section>