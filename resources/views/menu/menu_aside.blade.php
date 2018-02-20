<aside class="main-sidebar hidden-print ">
  <section class="sidebar" id="sidebar-scroll">
    <div class="user-panel">
      <div class="f-left image"><img src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="User Image" class="rounded-circle">
      </div>
      <div class="f-left info">
        <p>John Doe</p>
        <p class="designation">UX Designer <i class="fa fa-sort-down m-l-5"></i>
        </p>
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
          <li>
            <a class="waves-effect" href="{{ route('cicloFacturacion') }}">
              <i class="icon-arrow-right"></i>
              Ciclos de facturación
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
          <i class="icofont icofont-company"></i><span>Crédito </span><i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect" href="{{ route('proveedores') }}">
              <i class="icon-arrow-right"></i>
              Proveedores
            </a>
          </li>
          <li>
            <a class="waves-effect" href="#">
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
</aside>