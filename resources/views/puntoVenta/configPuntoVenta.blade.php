@extends('puntoVenta.indexConfig')
@section('content')

<div class="row">
	<div class="col-sm-12 p-0">
		<div class="main-header" style="margin-top: 0px;">
			<h4>Configuración Punto Venta</h4>
			<ol class="breadcrumb breadcrumb-title breadcrumb-arrow">
				<li class="breadcrumb-item">
					<a href="{{ route('home') }}" class="waves-effect">
						<i class="icofont icofont-home"></i>
					</a>
				</li>
				<li class="breadcrumb-item"><a href="{{ route('ptovta') }}" class="waves-effect">Punto de Venta</a>
				</li>
				<li class="breadcrumb-item ms-hover"><a href="#">Configuración</a>
				</li>
			</ol>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 divCajasDiaras">
	    <div class="card">
	        <div class="card-header">
	        	<div class="col-md-12">
		        	<center>
		        		<h5 class="card-header-text">
		        			Opciones de configuración del Punto de Venta
		        		</h5>
	                </center>
	                <br />
                	<div class="row">
						<div class="col-md-2">
                			<a  href="{{ route('puntoVentaConfig') }}" style="float:left;" name="agregar" id="agregar" class="btn btn-inverse-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Opciones de Configuración </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#" style="float:left;" name="botonGuardarConfiguracion" id="botonGuardarConfiguracion" class="btn btn-success waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Guardar Configuración</span>
							</a>
						</div>
						
						<div class="col-md-2" style="display: none;">
							<a  href="#" style="float:left;" name="botonCDRV" id="botonCDRV" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span></span>
							</a>
						</div>
						
						<div class="col-md-2" style="display: none;">
                			<a  href="#" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span></span>
							</a>
						</div>
						
						<div class="col-md-2" style="display: none;">
							<a  href="#" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span></span>
							</a>
						</div>
					</div>
            	</div>
	        </div>
	        {!! Form::open(['id'=>'FormOpcionesPtoVta','autocomplete' => 'off']) !!}
	       	<input type="hidden" name="IdPuntoVenta" id="IdPuntoVenta" value="{{ $v_opciones->IdPuntoVenta }}">

			<div class="card-block">
				<div class="col-md-12">
					<left>
		        		<h5 class="sub-title">
		        			Opciones Generales
		        		</h5>
	                </left>
					<div class="row">
						<div class="col-md-3">
                			¿ Manejo de Vendedores ? [{{ $v_opciones->ManejaVendedor }}]
                			<br />
                			<input type="checkbox" id="checkboxMV" name="checkboxMV" class="js-switch"
                			 {{ $v_opciones->ManejaVendedor ? 'checked="checked"' : '' }}>
                			<br/>
							<label for="Vendedores">Seleccione Vendedor</label><br/>
							<select class="form-control" style="width: 300px;text-overflow: ellipsis;" id="SelectVendedores" name="SelectVendedores">
			                  	<option value="0">Vendedores...</option>
			                	@foreach($v_vendedores as $vendedor)
			                		<option value="{{ $vendedor->IdVendedor }}" {{ ($v_opciones->IdVendedorDefault == $vendedor->IdVendedor) ? 'selected="selected"' : '' }}>{{ $vendedor->NombreVendedor }}</option>
			                  	@endforeach
							</select>
						</div>

						<div class="col-md-3">
                			¿ Manejo de Clientes ?
                			<br />
                			<input type="checkbox" id="checkboxMC" name="checkboxMC" class="js-switch"
                			 {{ $v_opciones->ManejaClientes ? 'checked="checked"' : '' }}> 
                			<br/>
						</div>
						<div class="col-md-3">
							¿ Cúal es el Tipo de Documento de Venta Principal ?
                			<br />
							<select class="form-control" style="width: 300px;text-overflow: ellipsis;" id="SelectDocumentoVTA" name="SelectDocumentoVTA">
								@foreach($v_tipo_dte as $tipoDTE)
			        					<option value="{{ $tipoDTE->id }}"
			                			{{ ($v_opciones->TipoDctoVta == $tipoDTE->id) ? 'selected="selected"' : '' }}>
			                			{{ $tipoDTE->text }}
			                		</option>
			                  	@endforeach
							</select>
						</div>
						<div class="col-md-3">
							¿Cuáles son las formas de pago aceptadas por el Punto de Venta?
                			<br />
							<select  id="SelectFormaPago[]" name="SelectFormaPago[]" class="js-example-basic-multiple" style="width: 300px;" multiple="multiple">
								@foreach($v_formas_pago as $formaPago)
									<?php if(strstr(','.$v_opciones->FormasPago.',',','.$formaPago->IdFormaPago.',')==true){ ?>
				         				<option value="{{$formaPago->IdFormaPago}}" selected="selected">{{ $formaPago->NombreFormaPago }}</option>
				         			<?php }else{ ?>
				         				<option value="{{$formaPago->IdFormaPago}}">{{$formaPago->NombreFormaPago}}</option>
									<?php } ?>
			                  	@endforeach
							</select>
						</div>
					</div>
					<br />
				</div>
				<br />
				<div class="col-md-12">
					<left>
		        		<h5 class="sub-title">
		        			Proceso de Ventas
		        		</h5>
	                </left>
					<div class="row">
						<div class="col-md-5">
                			¿ Punto de Venta genera Nota de Pedido / Pre-Venta / Cotización ?
						</div>
						<div class="col-md-7">
							<input type="checkbox" id="checkboxNV" name="checkboxNV" class="js-switch"
							{{ $v_opciones->NotaPedido ? 'checked="checked"' : '' }}>
						</div>				
					</div>
					<div class="row">
						<div class="col-md-4">
                			¿ Punto de Venta genera Documento Tributario ?
						</div>
						<div class="col-md-2">
							<input type="checkbox" id="checkboxDTE" name="checkboxDTE" class="js-switch"
							{{ $v_opciones->DTE ? 'checked="checked"' : '' }}>
						</div>
						<div class="col-md-6">
							<label for="SelectDTEPrincipal">Documento Tributario por Defecto</label>
							<select class="form-control" style="width: 300px;text-overflow: ellipsis;" id="SelectDTEPrincipal" name="SelectDTEPrincipal">
								<option value="0" selected="selected">Documentos...</option>
			                 	@foreach($v_tipo_dte as $tipoDTE)
			                		<option value="{{ $tipoDTE->id }}"
			                			{{ ($v_opciones->DTEDefautl == $tipoDTE->id) ? 'selected="selected"' : '' }}>
			                			{{ $tipoDTE->text }}</option>
			                  	@endforeach
							</select>
						</div>				
					</div>
					<br />

					<div class="row">
						<div class="col-md-5">
                			¿ Punto de Venta permite descuentos por Unidad Vendida ?
						</div>
						<div class="col-md-7">
							<input type="checkbox" id="checkboxDesctoUnidad" name="checkboxDesctoUnidad" class="js-switch"
							{{ $v_opciones->DescoUnidad ? 'checked="checked"' : '' }}>
						</div>				
					</div>
					<div class="row">
						<div class="col-md-4">
                			Los descuentos aplicados por Unidad Vendida son 
						</div>
						<div class="col-md-4">
							<div class="rkmd-checkbox checkbox-rotate checkbox-ripple">
								<label class="input-checkbox checkbox-primary">
									<input type="checkbox" id="checkboxTipoDesctoUnidad" name="checkboxTipoDesctoUnidad" value="1" {{ ($v_opciones->TipoDescoUnidad == 1) ? 'checked="checked"' : '' }} > 
									<span class="checkbox"></span>
								</label>
								<div class="captions">% Porcentaje Precio</div>

								<label class="input-checkbox checkbox-warnig">
									<input type="checkbox" id="checkboxTipoDesctoUnidad"  name="checkboxTipoDesctoUnidad" value="2" {{ ($v_opciones->TipoDescoUnidad == 2) ? 'checked="checked"' : '' }} >
									<span class="checkbox"></span>
								</label>
								<div class="captions">$ Monto del Precio</div>
							</div> 
						</div>	
						<div class="col-md-4">
							Monto Máximo de Descuento
							<input type="text" class="form-control" style="width: 100px;" id="DescoUnidadMax" name="DescoUnidadMax" placeholder="Porcentaje/Monto" maxlength="5" size="5" value="{{ $v_opciones->DescoUnidadMax }}">
						</div>				
					</div>
					<br />

					<div class="row">
						<div class="col-md-5">
                			¿ Punto de Venta permite descuentos al Total de la Venta ?
						</div>
						<div class="col-md-7">
							<input type="checkbox" id="checkboxDesctoTotal" name="checkboxDesctoTotal" class="js-switch"
							{{ $v_opciones->DescoTotal ? 'checked="checked"' : '' }}>
						</div>				
					</div>
					<div class="row">
						<div class="col-md-4">
                			Los descuentos aplicados al Total de la Venta son 
						</div>
						<div class="col-md-4">
							<div class="rkmd-checkbox checkbox-rotate checkbox-ripple">
								<label class="input-checkbox checkbox-primary">
									<input type="checkbox" id="checkboxTipoDesctoTotal" name="checkboxTipoDesctoTotal" value="1"   {{ ($v_opciones->TipoDescoTotal == 1) ? 'checked="checked"' : '' }} >
									<span class="checkbox"></span>
								</label>
								<div class="captions">% Porcentaje del Total</div>
								<label class="input-checkbox checkbox-warnig">
									<input type="checkbox"  id="checkboxTipoDesctoTotal" name="checkboxTipoDesctoTotal" value="2"  {{ ($v_opciones->TipoDescoTotal == 2) ? 'checked="checked"' : '' }} > 
									<span class="checkbox"></span>
								</label>
								<div class="captions">$ Monto del Total</div>
							</div> 
						</div>	
						<div class="col-md-4">
							Monto Máximo de Descuento
							<input type="text" class="form-control" style="width: 100px;" id="DescoTotalMax" name="DescoTotalMax" placeholder="Porcentaje/Monto" maxlength="5" size="5" value="{{ $v_opciones->DescoTotalMax }}">
						</div>				
					</div>
					<br />
				</div>
				<div class="col-md-12">
					<left>
		        		<h5 class="sub-title">
		        			Manejo de STOCK
		        		</h5>
	                </left>
					<div class="row">
						<div class="col-md-3">
                			¿ Punto de Venta Maneja STOCK ?
						</div>
						<div class="col-md-3">
                			¿ Emitir alerta de productos bajo STOCK ?
						</div>
						<div class="col-md-3">
                			¿ Alerta de productos bajo STOCK según STOCK mínimo?
						</div>
						<div class="col-md-3">
                			¿Punto de Venta permite venta de productos bajo STOCK ?
						</div>		
					</div>
					<div class="row">
						<div class="col-md-3">
							<input type="checkbox" id="checkboxSTOCK" name="checkboxSTOCK" class="js-switch" 
							{{ $v_opciones->ManejaSTOCK ? 'checked="checked"' : '' }} >
						</div>
						<div class="col-md-3">
							<input type="checkbox" id="checkboxBajoSTOCK" name="checkboxBajoSTOCK" class="js-switch" 
							{{ $v_opciones->AlertaBajoSTOCK ? 'checked="checked"' : '' }}>
						</div>
						<div class="col-md-3">
							<input type="checkbox" id="checkboxMinimoSTOCK" name="checkboxMinimoSTOCK" class="js-switch"  
							{{ $v_opciones->AlertaBajoMinimo ? 'checked="checked"' : '' }}>
						</div>	
						<div class="col-md-3">
							<input type="checkbox" id="checkboxSinSTOCK" name="checkboxSinSTOCK" class="js-switch" 
							{{ $v_opciones->VentaSinSTOCK ? 'checked="checked"' : '' }}>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-3">
                			¿ STOCK se rebaja desde la bodega ?
						</div>
						<div class="col-md-3">
                			
						</div>
						<div class="col-md-3">
                			
						</div>
						<div class="col-md-3">
							
                		</div>
					</div>
					<div class="row">
						<div class="col-md-3">
                			<select name="SelectBodegaSTOCK" id="SelectBodegaSTOCK" class="form-control">
                				<option value="0" selected="selected">Bodegas...</option>
                				@foreach($v_bodegas as $bodega)
			                		<option value="{{ $bodega->id }}"
			                			{{ ($v_opciones->BodegaSTOCK == $bodega->id) ? 'selected="selected"' : '' }}>
			                			{{ $bodega->text }}</option>
			                  	@endforeach
                			</select>
						</div>
						<div class="col-md-3">
                			
						</div>
						<div class="col-md-3">
                			
						</div>
						<div class="col-md-3">
							
                		</div>
					</div>
				</div>
				
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
