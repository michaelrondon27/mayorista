<div class="barra">
	<div class="usuario">
		<i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo "Usuario: ".$_users[$_SESSION['app_id']]['user']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre: ".$_users[$_SESSION['app_id']]['nombre'];?>
	</div>
</div>
<header>
	<nav>
		<div class="logo">
			<img class="foto" src="<?php echo LOGO;?>">
		</div>
		<ul class="menu">
			<li id="inicio"><a href="?view=index" class='navegacion'>Inicio</a></li>
			<li id="submenu1">
				<a class='navegacion'>Beneficiario&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down flecha" aria-hidden="true"></i></a>
				<ul id="children1">
					<li><a href="?view=beneficiario&mode=add" class='navegacion'>Nuevo Beneficiario</a></li>
					<li><a href="?view=beneficiario" class='navegacion'>Consultar Beneficiario</a></li>
				</ul>
			</li>
			<li id="submenu2">
				<a class='navegacion'>3er Cronograma&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down flecha" aria-hidden="true"></i></a>
				<ul id="children2">
					<li><a href="?view=3erCronograma&mode=addCotizacion" class='navegacion'>Nueva Cotización</a></li>
					<li><a href="?view=3erCronograma" class='navegacion'>Consultar Cotizaciones</a></li>
					<li><a href="?view=3erCronograma&mode=estadoFinanciero" class='navegacion'>Estado Financiero</a></li>
					<li><a href="?view=3erCronograma&mode=estadoCotizaciones" class='navegacion'>Reporte Mensual</a></li>
					<li><a href="?view=3erCronograma&mode=pdfDetallado" class='navegacion'>Reporte Detallado</a></li>
				</ul>
			</li>
			<li id="submenu4">
				<a class='navegacion'>4to Cronograma&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down flecha" aria-hidden="true"></i></a>
				<ul id="children4">
					<li><a href="?view=4toCronograma&mode=addCotizacion" class='navegacion'>Nueva Cotización</a></li>
					<li><a href="?view=4toCronograma" class='navegacion'>Consultar Cotizaciones</a></li>
					<li><a href="?view=4toCronograma&mode=estadoFinanciero" class='navegacion'>Estado Financiero</a></li>
					<li><a href="?view=4toCronograma&mode=estadoCotizaciones" class='navegacion'>Reporte Mensual</a></li>
					<li><a href="?view=4toCronograma&mode=pdfDetallado" class='navegacion'>Reporte Detallado</a></li>
				</ul>
			</li>
			<li id="submenu5">
				<a class='navegacion'>Juguetes&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down flecha" aria-hidden="true"></i></a>
				<ul id="children5">
					<li><a href="?view=Juguetes&mode=addCotizacion" class='navegacion'>Nueva Cotización</a></li>
					<li><a href="?view=Juguetes" class='navegacion'>Consultar Cotizaciones</a></li>
					<li><a href="?view=Juguetes&mode=estadoFinanciero" class='navegacion'>Estado Financiero</a></li>
					<li><a href="?view=Juguetes&mode=estadoCotizaciones" class='navegacion'>Reporte Mensual</a></li>
				</ul>
			</li>
			<?php
				if($_users[$_SESSION['app_id']]['id_perfil']==1 || $_users[$_SESSION['app_id']]['id_perfil']==3 || $_users[$_SESSION['app_id']]['id_perfil']==4){
					?>
						<li id="submenu6">
							<a class='navegacion'>Inventario&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down flecha" aria-hidden="true"></i></a>
							<ul id="children6">
								<li><a href="?view=inventario&mode=3erCronograma" class='navegacion'>3er Cronograma</a></li>
								<li><a href="?view=inventario&mode=4toCronograma" class='navegacion'>4to Cronograma</a></li>
								<li><a href="?view=inventario&mode=Juguetes" class='navegacion'>Juguetes</a></li>
							</ul>
						</li>
					<?php
				}
				if($_users[$_SESSION['app_id']]['id_perfil']==1){
					?>
						<li id="submenu3">
							<a class='navegacion'>Usuarios&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down flecha" aria-hidden="true"></i></a>
							<ul id="children3">
								<li><a href="?view=user&mode=add" class='navegacion'>Nuevo Usuario</a></li>
								<li><a href="?view=user" class='navegacion'>Consultar Usuarios</a></li>
							</ul>
						</li>
					<?php
				}
			?>
			<li id="matricula"><a href="?view=pass&mode=change" class='navegacion'>Cambiar Contraseña</a></li>
			<li id="cerrar"><a href="?view=logout" class='navegacion'>Cerrar Sesi&oacute;n&nbsp;&nbsp;&nbsp;<i class="fa fa-power-off" aria-hidden="true"></i></a></li>
		</ul>
	</nav>
</header>