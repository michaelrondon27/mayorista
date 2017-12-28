<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<body class="fondo">
	<div class="container-fluid" style="margin-left: 170px; padding-top: 50px;">
		<div class="mbr-header mbr-header--center mbr-header--std-padding">
		    <h2 class="mbr-header__text">BENEFICIARIOS</h2>
		</div>
		<div class="col-md-12">
			<div class="col-md-2">
				<a class="btn btn-danger" href="">Agregar Inventario <i class="fa fa-sign-in" aria-hidden="true"></i></a>
			</div>
		</div>
		<br><br>
		<table id="tabla" class="display" cellspacing="0" width="100%" style="font-size: 12px;">
			<thead>
				<tr>
					<th>N</th>
					<th>Almacenadora</th>
					<th>Rif</th>
					<th>Direcci&oacute;n</th>
					<th>Tel&eacute;fono</th>
					<th>Contacto</th>
					<th>Correo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$contador=1;
					foreach ($_inventario3er as $_inventario3er) {
						?>
							<tr>
								<td><?php echo $contador;?></td>
								<td><?php echo $_almacenadoras3er[$_inventario3er['id_almacenadora']]['nombre'];?></td>
								<td><?php echo $beneficiario['rif'];?></td>
								<td><?php echo $beneficiario['direccion']?></td>
								<?php
									foreach ($_cod_tlf as $cod_tlf) {
										if($cod_tlf['id_cod_tlf']==$beneficiario['id_cod_tlf']){
											?>
												<td><?php echo $cod_tlf['cod_tlf']."-".$beneficiario['telefono'];?></td>
											<?php
										}
									}
								?>
								<td><?php echo $beneficiario['contacto'];?></td>
								<td><?php echo $beneficiario['correo'];?></td>
								<td><a href="?view=beneficiario&mode=edit&id=<?php echo $beneficiario['id_empresa'];?>">Editar</a></td>
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