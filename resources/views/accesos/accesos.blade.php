@extends('accesos.index')
       
@if( !session()->has('perfilUsuario') or !session()->has('localesUsuario') )
    @section('content')
             <script Language="Javascript">
                var v_salir = 0;
                var ruta = "{{ URL::route('accesos') }}"
                var RutaSalir = "{{ URL::route('logout') }}";
                var d = [];      
            </script>
            <script src="{{ asset('js/accesos/accesos.js') }}"></script>
    @endsection       
@endif

@section('content')
<div class="row">
    <div class="col-sm-12 p-0">
        <div class="main-header">
        	<h4>{{Auth::user()->usrNickName}}, bienvenido a SG Plus</h4>
    	</div>
	</div>
</div>

<form id="FormSelectLocal" class="form-horizontal" novalidate>
    <input type="hidden" name='IdLocal' id='IdLocal' />
</form>

@if (count(Session::get('localesUsuario')) > 1)
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8" style="align-items: center;">
		<div class="card">
            <div class="card-header">
            	<h5 class="card-header-text">{{Auth::user()->usrNickName}} antes de comenzar ¿Donde trabajaras hoy?</h5>
            </div>
            <div class="card-block color-card">
                <div class="row text-center">
                	@foreach(Session::get('localesUsuario') as $local)
    					<div class="col-xl-4 col-md-6">
    						<div class="card card-inner-shadow">
		                        <div class="card-block global-cards goAccess" data-datac="{{$local->IdLocal}}">
		                            <h5 class="card-title">{{$local->NombreLocal}}</h5>
		                            <h6>
		                            	Empresa: {{$local->NombreFantasia}} <br />
		                            	RUT: {{$local->RUT}} <br />
		                            	Caja: 
		                            </h6>
		                            <br />
                                    <button id="botonSeleccionarLocal" name="botonSeleccionarLocal" data-datac="{{$local->IdLocal}}" class="btn btn-primary goAccess">Seleccionar</button>
		                        </div>
		                    </div>
                   		</div>
					@endforeach	
                </div>
                <!-- end of row -->
            </div>
        </div>
	</div>
	<div class="col-md-2"></div>
</div>
@endif

@if (count(Session::get('perfilesUsuario')) > 1)
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="card">
            <div class="card-header">
            	<h5 class="card-header-text">
            		@if (count(Session::get('localesUsuario')) > 1)
            			{{Auth::user()->usrNickName}} ya falta poco, ahora debes definir ¿Qué rol utilizaras para esta sesión?
            		@else
            			{{Auth::user()->usrNickName}} antes de comenzar, debes definir ¿Qué rol utilizaras para esta sessión? 
            		@endif
            	</h5>
            </div>
            <div class="card-block color-card">
                <div class="row text-center">
                	@foreach(Session::get('perfilesUsuario') as $perfil)
    					<div class="col-xl-3 col-md-6">
    						<div class="card card-inner-shadow">
		                        <div class="card-block global-cards">
		                            <h5 class="card-title">{{$perfil->des_perfil}}</h5>
		                            
		                            <br /><a href="#" class="btn btn-primary waves-effect waves-light">Seleccionar</a>
		                        </div>
		                    </div>
                   		</div>
					@endforeach	
                </div>
                <!-- end of row -->
            </div>
        </div>
	</div>
	<div class="col-md-2"></div>
</div>
@endif

<script Language="Javascript">
    var v_salir = 0;
	var ruta = "{{ URL::route('accesos') }}"
	var RutaSalir = "{{ URL::route('logout') }}";
	var d = [];
	
</script>
<script src="{{ asset('js/accesos/accesos.js') }}"></script>
@endsection	