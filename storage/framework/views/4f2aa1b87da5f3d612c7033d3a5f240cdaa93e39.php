<?php $__env->startSection('content'); ?>
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 2)!important;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Proveedores Registrados
	        		</h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<button style="float:right;" name="agregar" id="agregar" type="button" class="btn btn-primary waves-effect waves-light">
								<span>Agregar</span>
                			</button>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaProveedor" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-12 divDetalles" style="display:none;">
		<div class="card">
		    <div class="card-header">
		    	<center>
			    	<h5 id="spanTitulo" class="card-header-text"></h5>
		    	</center>
		    </div>
		    <div class="card-block">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
		                 	<div class="row">
								<div id="divVolver" class="col-md-12">
									<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
								</div>
							</div>
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#detalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles de Proveedor
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="acompras" class="nav-link" data-toggle="tab" href="#compras" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Compras Realizadas
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
							</div>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="detalles" role="tabpanel">
									<br><br>
									<?php echo Form::open(['id'=>'FormProveedor','autocomplete' => 'off']); ?>

									<?php echo Form::hidden('IdProveedor', '', [
									'id'            => 'IdProveedor',
									'class'         => 'form-control']); ?>

									<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
									<div class="row">
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="RUTProveedor" name="RUTProveedor" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="RUTProveedor">RUT Proveedor</label>
					                        </div>
										</div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
				                                <input id="CodigoProveedor" name="CodigoProveedor" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="CodigoProveedor">Codigo Proveedor</label>
					                        </div>
										</div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="RazonSocialProveedor" name="RazonSocialProveedor" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="RazonSocialProveedor">Razon Social</label>
					                        </div>
					                    </div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-4">
											<div class="md-input-wrapper">
				                                <input id="NombreFantasia" name="NombreFantasia" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="NombreFantasia">Nombre Fantasia</label>
					                        </div>
										</div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="Direccion" name="Direccion" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="Direccion">Dirección</label>
					                        </div>
										</div>
					                    <div class="col-sm-4">
											<div class="md-input-wrapper">
				                                <input id="Telefeno" name="Telefeno" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="Telefeno">Teléfeno</label>
					                        </div>
					                    </div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-2"></div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
				                                <input id="Vendedor" name="Vendedor" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="Vendedor">Vendedor</label>
					                        </div>
					                    </div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="EstadoProveedor" id="EstadoProveedor" class="md-disable md-valid" disabled></select>
				                                <label for="EstadoProveedor">Estado</label>
											</div>
					                    </div>
									</div>
									<br>
									<div align="center">
										<div class="pull-rigth">
											<div class="divBotones">
												<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
													Modificar
												</button>
											</div>
											<div class="divBotones" style="display:none;">
												<button id="cancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
													Cancelar
												</button>
					                			<button id="guardar"  type="button" class="btn btn-primary waves-effect waves-light">
													Guardar
					                			</button>
											</div>
										</div>
									</div>
									<?php echo Form::close(); ?>

		                        </div>
		                        <div class="tab-pane" id="compras" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaProductos" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
									</div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "<?php echo e(URL::route('proveedores')); ?>"
	var rutaA = "<?php echo e(URL::route('activarPro')); ?>"
	var rutaD = "<?php echo e(URL::route('detallesP')); ?>"
	var d = [];
	d['v_proveedores'] = JSON.parse(rhtmlspecialchars('<?php echo e(json_encode($v_proveedores)); ?>'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('<?php echo e(json_encode($v_estados)); ?>'));
</script>
<script src="<?php echo e(asset('js/proveedores/proveedores.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('menu.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>