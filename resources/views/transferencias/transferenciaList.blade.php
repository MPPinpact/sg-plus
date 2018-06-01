@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 2)!important;
	}
	.ErrorRut{
		color:#E02121;
		font-size: 10px;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
			<div class="card-block">
				<div class="col-md-12">
					<div class="row">

						<div class="col-md-2">
                			<a  href="{{ route('transferenciaList') }}" style="float:left;" name="botonListadoTransferencia" id="botonListadoTransferencia" class="btn btn-inverse-primary waves-effect waves-light btn-block" role="button">
								<span>Listado Transferencias </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="{{ route('transferenciaNew') }}" style="float:left;" name="botonNewTransferencia" id="botonNewTransferencia" class="btn btn-primary waves-effect waves-light btn-block" role="button">
								<span>Nueva Transferencia </span>
							</a>
						</div>

					</div>
				</div>
				<br />
			</div>
	    </div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 divDetalles">
		<div class="card">
		   <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Transferencias
	        		</h5>
                </center>
	        </div>
		    <div class="card-block">
				<div class="col-md-12">
	        		<div class="row">
	        			<div class="col-md-12 table-responsive">
							<table id="tablaTransferencia" ></table>
						</div>
						<form id="FormTransferenciaView" action="{{ action('TransferenciaBodegaController@getTransferenciaView') }}" method="post">
							{{ csrf_field() }}
							<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
							<input type="hidden" name="IdTransferencia" id="IdTransferencia">
						</form>
						{{ Form::open(array('route' => 'transferenciaView', 'method' => 'get')) }}
						{{ Form::close() }}
					</div>
				</div>
		    </div>
		</div>
	</div>
</div>

<script Language="Javascript">
	var rutaCMV = "{{ URL::route('transferenciaView') }}"

	var d = [];
	d['v_transferencia'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_transferencia) }}'));
</script>

<script src="{{ asset('js/transferencias/transferenciaList.js') }}"></script>
@endsection