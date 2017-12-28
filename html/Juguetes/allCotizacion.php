<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<?php
	if(isset($_GET['success'])){
		if($_GET['success']==1){
			?>
				<script>
					swal(
						{title:'Cotización eliminada!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
		if($_GET['success']==2){
			?>
				<script>
					swal(
						{title:'Orden generada!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
	}
?>
<body>
	<div class="container-fluid" style="margin-left: 180px; padding-top: 50px; margin-right: 40px;">
		<h3>Cotizaciones de Juguetes</h3>
		<table id="tabla" class="display" cellspacing="0" width="100%" style="font-size: 12px;">
			<thead>
				<tr>
					<th>N°</th>
					<th>Cotizaci&oacute;n</th>
					<th>Beneficiario</th>
					<th>Cant. Productos</th>
					<th>Fecha</th>
					<th>Orden de despacho</th>
					<th>Total</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$contador=1;
					foreach ($_cotizacionJuguetes as $_cotizacionJuguetes) {
						$fecha=date("d-m-Y", strtotime($_cotizacionJuguetes['fecha']));
						?>
							<tr>
									<td><?php echo $contador;?></td>
									<td><a href="?view=Juguetes&mode=verCotizacion&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>"><?php echo $_cotizacionJuguetes['cotizacion'];?></a></td>
									<td><?php echo $_beneficiario[$_cotizacionJuguetes['id_empresa']]['nombre'];?></td>
									<td><?php echo $_cotizacionJuguetes['unidades_total'];?></td>
									<td><?php echo $fecha;?></td>
									<td>
										<?php
											if($_cotizacionJuguetes['despacho']==0){
												echo "Sin Orden de Despacho.";
											}else{
												echo $_despachoJuguetes[$_cotizacionJuguetes['id_cotizacion']]['despacho'];
											}
										?>
									</td>
									<td><?php echo $_cotizacionJuguetes['total'];?></td>
									<td>
										<div class="dropdown">
	  										<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    										Acciones
	    										<span class="caret"></span>
	  										</button>
	  										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
	    										<li><a href="?view=Juguetes&mode=editCotizacion&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>">Editar Cotización</a></li>
	    										<li><a href="?view=Juguetes&mode=pdfCotizacion&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>" target="_blank">PDF Cotización</a></li>
	    										<li><a href="?view=Juguetes&mode=excelCotizacion&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>" target="_blank">EXCEL Cotización</a></li>
	    										<li><a href="?view=Juguetes&mode=factura&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>">Imprimir Factura</a></li>
	    										<?php
                        							if($_cotizacionJuguetes['despacho']==0){
                        								?>
                        									<li><a href="?view=Juguetes&mode=addOrden&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>">Generar Orden</a></li>
                        								<?php
                        							}
                        						?>
                        						<?php
                        							if($_cotizacionJuguetes['despacho']==1){
                        								?>
                        									<li><a href="?view=Juguetes&mode=editOrden&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>">Editar Orden</a></li>
                        									<li><a href="?view=Juguetes&mode=pdfOrdenDespacho&id=<?php echo $_cotizacionJuguetes['id_cotizacion'];?>" target="_blank">PDF Orden</a></li>
                        								<?php
                        							}
                        						?>
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