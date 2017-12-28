<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
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
<script src="views/app/js/calculo4to.js"></script>
<body class="fondo">
	<div class="container-fluid">
		<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-7" style="margin-left: 180px;">
   		    <div class="mbr-section__container mbr-section__container--std-padding container" style="padding-top: 93px; padding-bottom: 93px;">
		        <div class="row">
		            <div class="col-sm-12">
		            	<div class="col-md-2">
							<a class="btn btn-danger" href="?view=4toCronograma&mode=editCotizacion&id=<?php echo $_GET['id']?>"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
						</div>
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">AGREGAR PRODUCTO A LA COTIZACIÓN <?php echo $_cotizacion4to[$_GET['id']]['cotizacion'];?> del 4to Cronograma</h2>
		                        </div>
		                        <p>Los campos con (*) son obligatorios.</p>
		                        <form class="form-horizontal" method="POST" action="?view=4toCronograma&mode=addProducto&id=<?php echo $_GET['id'];?>">
									<input type="hidden" id="art1" value="1">
		                            <div class="form-group">
				  						<div class="col-sm-2">
											<label>*Almacenadora:</label>
										</div>
									    <div class="col-sm-8">
											<select class="form-control" id="alma1" name="alma1">
												<option value="">Seleccione</option>
											   	<?php
											   		foreach ($_almacenadoras4to as $almacenadoras) {
											   			?>
											   				<option value="<?php echo $almacenadoras['id_almacenadora'];?>"><?php echo $almacenadoras['nombre'];?></option>
											   			<?php
											   		}
											   	?>
											</select>
										</div>
									</div>
									<div class="form-group">
				  						<div class="col-sm-2">
											<label>*Producto:</label>
										</div>
									    <div class="col-sm-8">
											<select class="form-control" id="prod1" name="prod1">
												<option value="">Seleccione</option>
											   	<?php
											   		foreach ($_producto4to as $producto) {
												   		?>
												   			<option value="<?php echo $producto['id_producto'];?>"><?php echo $producto['producto'];?></option>
												   		<?php
												   	}
												?>
											</select>
										</div>
									</div>
		                            <div class="form-group">
				  						<div class="col-sm-2">
											<label>*Modelo:</label>
										</div>
									    <div class="col-sm-8">
											<select class="form-control" id="modelo1" name="mod1">
												<option value="">Seleccione</option>
											</select>
										</div>
									</div>
									<div class="form-group">
									    <div class="col-sm-2">
											<label>*Cantidad:</label>
										</div>
									    <div class="col-sm-8" id="disponible1">
									    	<input type="text" class="form-control" id="cant" name="cant1" onkeypress="return solonumeros(event)">
									    </div>
									</div>
									<div class="form-group">
									    <div class="col-sm-2">
											<label>Precio Total:</label>
										</div>
									    <div class="col-sm-8">
											<input type="text" class="form-control" id="subtotal1" name="subtotal1" onkeypress="return deshabilitarteclas(event)">
											<input type="hidden" class="form-control" id="sub1" name="sub1">
										</div>
									</div>
		                            <div class="mbr-buttons mbr-buttons--center"><button type="submit" class="mbr-buttons__btn btn btn-lg btn-danger">GUARDAR</button></div>
		                        </form>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</section>
	</div>
	<?php
		include(HTML_DIR."overall/footer.php");
	?>
</body>