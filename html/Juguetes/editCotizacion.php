<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
	$db=new Conexion();
?>
<link rel="stylesheet" href="views/app/css/jquery-ui.css">
<script src="views/app/js/jquery-ui.js"></script>
<?php
	if(isset($_GET['success'])){
		if($_GET['success']==1){
			?>
				<script>
					swal(
						{title:'Cotización editada!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==2){
			?>
				<script>
					swal(
						{title:'Producto agregado!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==3){
			?>
				<script>
					swal(
						{title:'Descuento agregado!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==4){
			?>
				<script>
					swal(
						{title:'Producto elimininado!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==5){
			?>
				<script>
					swal(
						{title:'Producto editado!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
	}
	if(isset($_GET['error'])){
		if($_GET['error']==1){
			?>
				<script>
					swal(
						{title:'Debe llenar los campos indicados!',
						type:'warning',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
	}
?>
<body class="fondo">
	<div class="container-fluid">
		<div class="row" style="padding-left: 40px; padding-top: 80px; width: 100%;">
		    <div class="col-sm-12">
		        <div class="row">
		            <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                    <h2 class="mbr-header__text">EDITAR COTIZACIÓN <?php echo $_cotizacionJuguetes[$_GET['id']]['cotizacion'];?> de Juguetes</h2>
		                </div>
		                <form method="post" action="?view=Juguetes&mode=editCotizacion&id=<?php echo $_GET['id'];?>" id="form_cotizacion">
							<div class="form-group col-sm-12">
								<div class="col-sm-3">
									<label for="cotizacion" class="control-label"><strong>Cotizaci&oacute;n Nro.:</strong></label>
							    </div>
							    <div class="col-sm-3">
							      <input type="text" class="form-control" id="cotizacion" name="cotizacion" value="<?php echo $_cotizacionJuguetes[$_GET['id']]['cotizacion'];?>" required>
							    </div>
								<label class="col-sm-3 control-label">
									<strong>Fecha: </strong>
								</label>
								<div class="col-sm-3">
							      <input type="text" class="form-control" id="datepicker" name="fecha" value="<?php echo $fec=date("d-m-Y", strtotime($_cotizacionJuguetes[$_GET['id']]['fecha']));?>" autocomplete="off" required>
							    </div>
							</div>
							<div class="form-group col-sm-12">
								<label class="col-sm-2 control-label">BENEFICIARIO</label>
								<div class="col-sm-10">
									<select class="form-control" name="empresa">
											<option value="">Seleccione</option>
											<?php
												foreach ($_beneficiario as $beneficiario) {
													if($beneficiario['id_empresa']==$_cotizacionJuguetes[$_GET['id']]['id_empresa']){
														?>
															<option selected value="<?php echo $beneficiario['id_empresa']?>"><?php echo $beneficiario['nombre'];?></option>
														<?php
													}else{
														?>
															<option value="<?php echo $beneficiario['id_empresa']?>"><?php echo $beneficiario['nombre'];?></option>
														<?php
													}
												}
									    	?>
							    	</select>
							    </div>
							</div>
							<div class="form-group col-sm-12">
								<div class="col-sm-5"></div>
								<div class="col-sm-7">
									<button type="submit" class="btn btn-danger">GUARDAR</button>
								</div>
							</div>
						</form>
			            <div class="col-md-2">
							<a class="btn btn-danger" href="?view=Juguetes&mode=addProducto&id=<?php echo $_GET['id'];?>">Agregar Producto</a>
						</div>
						<div class="col-md-2">
							<a class="btn btn-danger" href="?view=Juguetes&mode=addDescuento&id=<?php echo $_GET['id'];?>">Agregar o Editar Descuento</a>
						</div>
						<div class="form-group">
				            <table class="table table-bordered" id="mitabla">
								<tr>
									<td align="center">ITEM</td>
									<td align="center">ALMACENADORA</td>
									<td align="center">PRODUCTO</td>
									<td align="center">CANTIDAD</td>
									<td align="center">PRECIO TOTAL</td>
									<td></td>
								</tr>
								<?php 
									$id=$_GET['id']; 
									$sql=$db->query("SELECT o.id_ordenes, o.cantidad, o.precio_total, a.nombre, p.producto FROM ordenes_juguetes o INNER JOIN almacenadoras_juguetes a ON o.id_almacenadora=a.id_almacenadora INNER JOIN productos_juguetes p ON o.id_producto=p.id_producto WHERE o.id_cotizacion=$id;");
									$contador=1;
									if($db->rows($sql)){
										while($data=$db->recorrer($sql)){
											?>
												<tr>
													<td align="center"><?php echo $contador;?></td>
													<td align="center"><?php echo $data[3];?></td>
													<td align="center"><?php echo $data[4];?></td>
													<td align="center"><?php echo $data[1];?></td>
													<td align="center"><?php echo $data[2];?></td>
													<td>
														<div class="dropdown">
					  										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					    										Acciones
					    										<span class="caret"></span>
					  										</button>
					  										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					    										<li><a href="?view=Juguetes&mode=editProducto&orden=<?php echo $data[0];?>&id=<?php echo $id;?>">Editar Producto</a></li>
																<li><a onclick="DeleteItem('¿Está seguro de eliminar este producto?','?view=Juguetes&mode=deleteProducto&orden=<?php echo $data[0];?>&id=<?php echo $_GET['id'];?>')"">Eliminar Producto</a></li>
					  										</ul>
														</div>
													</td>
												</tr>
											<?php
											$contador++;
										}
									}
								?>
								<tr>
									<td colspan='3' align='right' class='abajo izquierda'>
										<strong>CANTIDAD TOTAL:</strong>
									</td>
									<td align=center><?php echo $_cotizacionJuguetes[$_GET['id']]['unidades_total'];?></td>
								</tr>
								<?php
									if($_cotizacionJuguetes[$_GET['id']]['desc_porcentaje']!=""){
										?>
											<tr>
												<td colspan='4' align='right'>
													<strong>SUBTOTAL:</strong>
												</td>
												<td align=center><?php echo $_cotizacionJuguetes[$_GET['id']]['subtotal'];?></td>
											</tr>
											<tr>
												<td colspan='3' align='right'>
													<strong>DESCUENTO:</strong>
												</td>
												<td align=center><?php echo $_cotizacionJuguetes[$_GET['id']]['desc_porcentaje']."%";?></td>
												<td  align=center><?php echo $_cotizacionJuguetes[$_GET['id']]['descuento'];?></td>
											</tr>
										<?php
									}
								?>
								<tr>
									<td colspan='4' align='right' class='izquierda'>
										<strong>TOTAL:</strong>
									</td>
									<td align=center><?php echo $_cotizacionJuguetes[$_GET['id']]['total'];?></td>
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