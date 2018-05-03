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
      <a href="/home" class="settings-menu">
        <i class="icon-speedometer"></i><span>  Dashboard </span>
      </a>
    </li>
    <li class="treeview">
      <a href="{{ route('ptovta') }}" class="settings-menu">
        <i class="icon-calculator"></i><span>  Punto Venta </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="icon-calculator"></i><span>Punto de Venta</span><i class="icon-arrow-down"></i>
      </a>
      <ul class="treeview-menu">
        <li>  
          <a class="waves-effect" href="{{ route('cajaDiaria') }}">
            <i class="icon-arrow-right"></i>
            Caja Diaria
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('ventas') }}">
            <i class="icon-arrow-right"></i>
            Pre-Venta
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('ventas') }}">
            <i class="icon-arrow-right"></i>
            Venta
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('ventas') }}">
            <i class="icon-arrow-right"></i>
            Consulta Crédito
          </a>
        </li>
      </ul>
    </li><li class="treeview">
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
        <li>
          <a class="waves-effect" href="{{ route('vendedores') }}">
            <i class="icon-arrow-right"></i>
            Vendedores
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('FormaPago') }}">
            <i class="icon-arrow-right"></i>
            Formas de Pago
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
        <li>
          <a class="waves-effect" href="{{ route('AbonoCliente') }}">
            <i class="icon-arrow-right"></i>
            Abono Clientes
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="icon-credit-card"></i><span>Crédito </span><i class="icon-arrow-down"></i>
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
        <i class="icon-bag"></i><span>Productos </span><i class="icon-arrow-down"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a class="waves-effect" href="{{ route('productos') }}">
            <i class="icon-arrow-right"></i>
            Productos
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('inventario') }}">
            <i class="icon-arrow-right"></i>
            Inventario
          </a>
        </li>
         <li class="p-0">
            <div class="dropdown-divider m-0"></div>
          </li>
        <li>
          <a class="waves-effect" href="{{ route('umedidas') }}">
            <i class="icon-grid"></i>
            Unidad de medida
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('familias') }}">
           <i class="icon-grid"></i>
            Familias
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('subfamilias') }}">
            <i class="icon-grid"></i>
            Subfamilias
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('impuestos') }}">
            <i class="icon-grid"></i>
            Impuestos
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="icon-bag"></i><span>Compras</span><i class="icon-arrow-down"></i>
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
        <i class="icon-settings"></i><span>Administración </span><i class="icon-arrow-down"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a class="waves-effect" href="{{ route('usuarios') }}">
			<i class="icon-people"></i>
            Usuarios
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('empresas') }}">
            <i class="icon-briefcase"></i>
            Empresas
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('locales') }}">
            <i class="icon-home"></i>
            Locales
          </a>
        </li>
        <li>
          <a class="waves-effect" href="{{ route('bodegas') }}">
            <i class="icon-grid"></i>
            Bodegas
          </a>
        </li>
      </ul>
    </li>
  </ul>
</section>