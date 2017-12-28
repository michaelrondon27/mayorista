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
		<h3>Cotizaciones del 3er Cronograma</h3>
		<div class="col-md-12">
			<div class="col-md-2">
				<a class="btn btn-danger" href="?view=3erCronograma&mode=addCotizacion">Nueva Cotización <i class="fa fa-sign-in" aria-hidden="true"></i></a>
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
					foreach ($_cotizacion3er as $cotizacion3er) {
						$fecha=date("d-m-Y", strtotime($cotizacion3er['fecha']));
						if($cotizacion3er['despacho']==0){
							$color="#FFF";
						}else if($cotizacion3er['despacho']==1){
							$color="#CCFFD4";
						}else if($cotizacion3er['despacho']==2){
							$color="#FFCCCC";
						}
						?>
							<tr style="background-color: <?php echo $color;?>;">
								<td><?php echo $contador;?></td>
								<td><a href="?view=3erCronograma&mode=verCotizacion&id=<?php echo $cotizacion3er['id_cotizacion'];?>"><?php echo $cotizacion3er['cotizacion'];?></a></td>
								<td><?php echo $_beneficiario[$cotizacion3er['id_empresa']]['nombre'];?></td>
								<td><?php echo $cotizacion3er['unidades_total'];?></td>
								<td><?php echo $fecha;?></td>
								<td>
									<?php
										if($cotizacion3er['despacho']==0){
											echo "Sin Orden de Despacho.";
										}else if($cotizacion3er['despacho']==1){
											echo $_despacho3er[$cotizacion3er['id_cotizacion']]['despacho'];
										}else if($cotizacion3er['despacho']==2){
											echo "Anulada";
										}
									?>
								</td>
								<td><?php echo $cotizacion3er['total'];?></td>
								<td>
									<div class="dropdown">
	  									<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    									Acciones
	    									<span class="caret"></span>
	  									</button>
	  									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
	  										<?php
	  											if($cotizacion3er['despacho']==0 || $cotizacion3er['despacho']==1){
	  												?>
	  													<li><a href="?view=3erCronograma&mode=editCotizacion&id=<?php echo $cotizacion3er['id_cotizacion'];?>">Editar Cotización</a></li>
				    									<li><a href="?view=3erCronograma&mode=pdfCotizacion&id=<?php echo $cotizacion3er['id_cotizacion'];?>" target="_blank">PDF Cotización</a></li>
				    									<li><a href="?view=3erCronograma&mode=excelCotizacion&id=<?php echo $cotizacion3er['id_cotizacion'];?>" target="_blank">EXCEL Cotización</a></li>
				    									<li><a href="?view=3erCronograma&mode=factura&id=<?php echo $cotizacion3er['id_cotizacion'];?>">Imprimir Factura</a></li>
	  												<?php
	  											}
                        						if($cotizacion3er['despacho']==0){
                        							?>
                        								<li><a href="?view=3erCronograma&mode=addOrden&id=<?php echo $cotizacion3er['id_cotizacion'];?>">Generar Orden</a></li>
                        								<li><a onclick="AnularItem('¿Está seguro de anular esta cotización?','?view=3erCronograma&mode=anularCotizacion&id=<?php echo $cotizacion3er['id_cotizacion'];?>')">Anular</a></li>
                        							<?php
                        						}
                        						if($cotizacion3er['despacho']==1){
                        							?>
                        								<li><a href="?view=3erCronograma&mode=editOrden&id=<?php echo $cotizacion3er['id_cotizacion'];?>">Editar Orden</a></li>
                        								<li><a href="?view=3erCronograma&mode=pdfOrdenDespacho&id=<?php echo $cotizacion3er['id_cotizacion'];?>" target="_blank">PDF Orden <i class="fa fa-file-pdf-o rojo" aria-hidden="true"></i></a>
                        							<?php
                        						}
                        						if($cotizacion3er['despacho']==2){
                        							?>
                        								<li><a onclick="ReversarItem('¿Está seguro de reversar esta cotización?','?view=3erCronograma&mode=reversarCotizacion&id=<?php echo $cotizacion3er['id_cotizacion'];?>')">Reversar</a></li>
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