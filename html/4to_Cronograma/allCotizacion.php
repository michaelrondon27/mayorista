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
		}else if($_GET['success']==2){
			?>
				<script>
					swal(
						{title:'Orden generada!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==3){
			?>
				<script>
					swal(
						{title:'Cotización anulada!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==4){
			?>
				<script>
					swal(
						{title:'Cotización reversada!',
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
		<h3>Cotizaciones del 4to Cronograma</h3>
		<div class="col-md-12">
			<div class="col-md-2">
				<a class="btn btn-danger" href="?view=4toCronograma&mode=addCotizacion">Nueva Cotización <i class="fa fa-sign-in" aria-hidden="true"></i></a>
			</div>
		</div>
		<br><br>
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
					foreach ($_cotizacion4to as $_cotizacion4to){
						$fecha=date("d-m-Y", strtotime($_cotizacion4to['fecha']));
						if($_cotizacion4to['despacho']==0){
							$color="#FFF";
						}else if($_cotizacion4to['despacho']==1){
							$color="#CCFFD4";
						}else if($_cotizacion4to['despacho']==2){
							$color="#FFCCCC";
						}
						?>
							<tr style="background-color: <?php echo $color;?>;">
								<td><?php echo $contador;?></td>
								<td><a href="?view=4toCronograma&mode=verCotizacion&id=<?php echo $_cotizacion4to['id_cotizacion'];?>"><?php echo $_cotizacion4to['cotizacion'];?></a></td>
								<td><?php echo $_beneficiario[$_cotizacion4to['id_empresa']]['nombre'];?></td>
								<td><?php echo $_cotizacion4to['unidades_total'];?></td>
								<td><?php echo $fecha;?></td>
								<td>
									<?php
										if($_cotizacion4to['despacho']==0){
											echo "Sin Orden de Despacho.";
										}else if($_cotizacion4to['despacho']==1){
											echo $_despacho4to[$_cotizacion4to['id_cotizacion']]['despacho'];
										}else if($_cotizacion4to['despacho']==2){
											echo "Anulada";
										}
									?>
								</td>
								<td><?php echo $_cotizacion4to['total'];?></td>
								<td>
									<div class="dropdown">
	  									<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    									Acciones
	    									<span class="caret"></span>
	  									</button>
	  									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        					<?php
	  											if($_cotizacion4to['despacho']==0 || $_cotizacion4to['despacho']==1){
	  												?>
	  													<li><a href="?view=4toCronograma&mode=editCotizacion&id=<?php echo $_cotizacion4to['id_cotizacion'];?>">Editar Cotización</a></li>
				    									<li><a href="?view=4toCronograma&mode=pdfCotizacion&id=<?php echo $_cotizacion4to['id_cotizacion'];?>" target="_blank">PDF Cotización</a></li>
				    									<li><a href="?view=4toCronograma&mode=excelCotizacion&id=<?php echo $_cotizacion4to['id_cotizacion'];?>" target="_blank">EXCEL Cotización</a></li>
				    									<li><a href="?view=4toCronograma&mode=factura&id=<?php echo $_cotizacion4to['id_cotizacion'];?>">Imprimir Factura</a></li>
	  												<?php
	  											}
                        						if($_cotizacion4to['despacho']==0){
                        							?>
                        								<li><a href="?view=4toCronograma&mode=addOrden&id=<?php echo $_cotizacion4to['id_cotizacion'];?>">Generar Orden</a></li>
                        								<li><a onclick="AnularItem('¿Está seguro de anular esta cotización?','?view=4toCronograma&mode=anularCotizacion&id=<?php echo $_cotizacion4to['id_cotizacion'];?>')">Anular</a></li>
                        							<?php
                        						}
                        						if($_cotizacion4to['despacho']==1){
                        							?>
                        								<li><a href="?view=4toCronograma&mode=editOrden&id=<?php echo $_cotizacion4to['id_cotizacion'];?>">Editar Orden</a></li>
                        								<li><a href="?view=4toCronograma&mode=pdfOrdenDespacho&id=<?php echo $_cotizacion4to['id_cotizacion'];?>" target="_blank">PDF Orden <i class="fa fa-file-pdf-o rojo" aria-hidden="true"></i></a>
                        							<?php
                        						}
                        						if($_cotizacion4to['despacho']==2){
                        							?>
                        								<li><a onclick="ReversarItem('¿Está seguro de reversar esta cotización?','?view=4toCronograma&mode=reversarCotizacion&id=<?php echo $_cotizacion4to['id_cotizacion'];?>')">Reversar</a></li>
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