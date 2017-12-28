<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
	$db=new Conexion();
?>
<body>
	<div class="container-fluid fondo">
	    <div class="row" style="padding-left: 40px; padding-top: 80px; width: 100%;">
		    <div class="col-sm-12">
		        <div class="row">
		            <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		            	<div class="col-md-2">
							<a class="btn btn-danger" href="?view=3erCronograma&mode=allCotizacion"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
						</div>
		                <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                    <h2 class="mbr-header__text">VER COTIZACIÓN <?php echo $_cotizacion3er[$_GET['id']]['cotizacion'];?> del 3er Cronograma</h2>
		                </div>
			            <div class="form-group">
			                Cotización Nro: <?php echo $_cotizacion3er[$_GET['id']]['cotizacion'];?>
			                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			              	Fecha: <?php echo $fec=date("d-m-Y", strtotime($_cotizacion3er[$_GET['id']]['fecha']));?>
			               	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			               	Beneficiario: <?php echo $_beneficiario[$_cotizacion3er[$_GET['id']]['id_empresa']]['nombre'];?>
			            </div>
						<div class="form-group">
				            <table class="table table-bordered" id="mitabla">
								<tr>
									<td align="center">ITEM</td>
									<td align="center">ALMACENADORA</td>
									<td align="center">PRODUCTO</td>
									<td align="center">MODELO</td>
									<td align="center">CANTIDAD</td>
									<td align="center">PRECIO TOTAL</td>
								</tr>
								<?php 
									$id=$_GET['id']; 
									$sql=$db->query("SELECT o.id_ordenes, o.cantidad, o.precio_total, a.nombre, p.producto, m.modelo FROM ordenes o INNER JOIN almacenadoras a ON o.id_almacenadora=a.id_almacenadora INNER JOIN productos p ON o.id_producto=p.id_producto INNER JOIN modelo m ON o.id_modelo=m.id_modelo WHERE id_cotizacion=$id;");
									$contador=1;
									if($db->rows($sql)){
										while($data=$db->recorrer($sql)){
											?>
												<tr>
													<td align="center"><?php echo $contador;?></td>
													<td align="center"><?php echo $data[3];?></td>
													<td align="center"><?php echo $data[4];?></td>
													<td align="center"><?php echo $data[5];?></td>
													<td align="center"><?php echo $data[1];?></td>
													<td align="center"><?php echo $data[2];?></td>
												</tr>
											<?php
											$contador++;
										}
									}
								?>
								<tr>
									<td colspan='4' align='right' class='abajo izquierda'>
										<strong>CANTIDAD TOTAL:</strong>
									</td>
									<td align=center><?php echo $_cotizacion3er[$_GET['id']]['unidades_total'];?></td>
								</tr>
								<?php
									if($_cotizacion3er[$_GET['id']]['desc_porcentaje']!=""){
										?>
											<tr>
												<td colspan='5' align='right'>
													<strong>SUBTOTAL:</strong>
												</td>
												<td align=center><?php echo $_cotizacion3er[$_GET['id']]['subtotal'];?></td>
											</tr>
											<tr>
												<td colspan='4' align='right'>
													<strong>DESCUENTO:</strong>
												</td>
												<td align=center><?php echo $_cotizacion3er[$_GET['id']]['desc_porcentaje']."%";?></td>
												<td  align=center><?php echo $_cotizacion3er[$_GET['id']]['descuento'];?></td>
											</tr>
										<?php
									}
								?>
								<tr>
									<td colspan='5' align='right' class='izquierda'>
										<strong>TOTAL:</strong>
									</td>
									<td align=center><?php echo $_cotizacion3er[$_GET['id']]['total'];?></td>
								</tr>
							</table>       
			            </div>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
	<?php
		include(HTML_DIR."overall/footer.php");
	?>
</body>
</html>