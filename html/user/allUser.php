<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<body>
	<div class="container-fluid" style="margin-left: 170px; padding-top: 50px;">
		<div class="mbr-header mbr-header--center mbr-header--std-padding">
		    <h2 class="mbr-header__text">USUARIOS</h2>
		</div>
		<table id="tabla" class="display" cellspacing="0" width="100%" style="font-size: 12px;">
			<thead>
				<tr>
					<th>N</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Estatus</th>
					<th>Perfil</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$contador=1;
					foreach ($_SESSION['users'] as $user) {
						?>
							<tr>
								<td><?php echo $contador;?></td>
								<td><?php echo $user['user'];?></td>
								<td><?php echo $user['nombre'];?></td>
								<td><?php echo $_status[$user['id_status']]['status'];?></td>
								<td><?php echo $_perfil[$user['id_perfil']]['perfil'];?></td>
								<td>
									<div class="dropdown">
	  									<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    									Acciones
	    									<span class="caret"></span>
	  									</button>
	  									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
	    									<li><a href="?view=user&mode=edit&id=<?php echo $user['id_usuario']?>">Editar</a></li>
	    									<li><a href="?view=user&mode=adminPass&id=<?php echo $user['id_usuario']?>">Cambiar Password</a></li>
	  									</ul>
									</div>
								</td>
							</tr>
						<?php
						$contador++;
					}
				?>
			</tbody>
		</table>
	</div>
	<script>
		$(document).ready(function(){
			$("#tabla").DataTable();
		});
	</script>
	<br><br>
	<?php
		include(HTML_DIR."overall/footer.php");
	?>
</body>
</html>