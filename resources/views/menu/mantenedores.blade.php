<style type="text/css" media="screen">
.users-main{
	all: unset;
	height: 482px;	
}	
</style>
<div class="col-md-2">
	<div class="card">
		<div class="card-header">
			<center>
				<h5 class="card-header-text">
					Mantenedores
				</h5>
			</center>
		</div>
		<div class="users-main contact-box users-main-fix">
			<div class="card-block user-box">
				<div class="user-box-users">
					<ul class="scroll-list">
						<li>
							<a class="waves-effect" href="{{ route('usuarios') }}">
								<u>Usuarios</u>
							</a>
						</li>
						<li>
							<a class="waves-effect" href="{{ route('empresas') }}">
								<u>Empresas</u>
							</a>
						</li>
						<li>
							<a class="waves-effect" href="{{ route('locales') }}">
								<u>Locales</u>
							</a>
						</li>
						<li>
							<a class="waves-effect" href="{{ route('bodegas') }}">
								<u>Bodegas</u>
							</a>
						</li>
						<li>
							<a class="waves-effect" href="{{ route('umedidas') }}">
				                <u>Unidad de Medida</u>
				            </a>													
						</li>
						<li>
							<a class="waves-effect" href="{{ route('familias') }}">
				                <u>Familia</u>
				            </a>													
						</li>
						<li>
			             	<a class="waves-effect" href="{{ route('subfamilias') }}">
			                	<u>Subfamilias</u>
			              	</a>
			            </li>
						<li>
			             	<a class="waves-effect" href="{{ route('impuestos') }}">
			                	<u>Impuestos</u>
			              	</a>
			            </li>
			            <li>
			             	<a class="waves-effect" href="{{ route('productos') }}">
			                	<u>Productos</u>
			              	</a>
			            </li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>