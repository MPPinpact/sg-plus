<?php $__env->startSection('content'); ?>
<div class="row">
	<div class="col-md-12 divDetalles">
		<div class="card">
			<div class="card-header">
				<center>
					<h5 id="spanTitulo" class="card-header-text"></h5>
				</center>
			</div>
			<div class="card-block">
				<div class="col-md-12 divForm">
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
							<table id="tablaSubfamilias" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
				</div>
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					<?php echo Form::open(['id'=>'FormSubfamilia','autocomplete' => 'off']); ?>

					<?php echo Form::hidden('IdSubFamilia', '', [
					'id'            => 'IdSubFamilia',
					'class'         => 'form-control']); ?>

					<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="NombreSubFamilia" name="NombreSubFamilia" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="NombreSubFamilia">Nombre Subfamilia</label>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="IdFamilia" id="IdFamilia" class="md-disable md-valid" disabled></select>
								<label for="IdFamilia">Familia</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
						<div class="md-input-wrapper">
								<select name="IdUnidadMedida" id="IdUnidadMedida" class="md-disable md-valid" disabled></select>
								<label for="IdUnidadMedida">Unidad de Medida</label>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="EstadoSubFamilia" id="EstadoSubFamilia" class="md-disable md-valid" disabled></select>
								<label for="EstadoSubFamilia">Estado</label>
							</div>
						</div>
					</div>
					<br>
					<div align="center">
						<div class="pull-rigth">
							<div id="divBtnModificar">
								<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
									Modificar
								</button>
							</div>
							<div id="divBtnAceptar">
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
			</div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "<?php echo e(URL::route('subfamilias')); ?>"
	var rutaA = "<?php echo e(URL::route('activarSf')); ?>"
	var rutaB = "<?php echo e(URL::route('subfamiliab')); ?>"
	var d = [];
	d['v_subfamilias'] = JSON.parse(rhtmlspecialchars('<?php echo e(json_encode($v_subfamilias)); ?>'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('<?php echo e(json_encode($v_estados)); ?>'));
	d['v_unidadmedida'] = JSON.parse(rhtmlspecialchars('<?php echo e(json_encode($v_unidadmedida)); ?>'));
	d['v_familia'] = JSON.parse(rhtmlspecialchars('<?php echo e(json_encode($v_familia)); ?>'));
</script>
<script src="<?php echo e(asset('js/subfamilias/subfamilias.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('menu.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>