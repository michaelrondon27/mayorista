<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
	$db=new Conexion();
?>
<body class="fondo">
	<div class="container-fluid">
		<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-7" style="margin-left: 180px;">
   		    <div class="mbr-section__container mbr-section__container--std-padding container" style="padding-top: 93px; padding-bottom: 93px;">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">AGREGAR DESCUENTO A LA COTIZACIÓN <?php echo $_cotizacionJuguetes[$_GET['id']]['cotizacion'];?> de Juguetes</h2>
		                        </div>
		                        <p>Si desea quitarle el descuento solo deje el campo vacio y le das click en guardar.</p>
		                        <form class="form-horizontal" method="POST" action="?view=Juguetes&mode=addDescuento&id=<?php echo $_GET['id'];?>">
									<div class="form-group">
										<div class="col-sm-2"></div>
									    <div class="col-sm-2">
											<label>Descuento:</label>
										</div>
									    <div class="col-sm-4">
									    	<input type="text" class="form-control" id="descuento" name="descuento" onkeypress="return solonumeros(event)">
									    </div>
									</div>
									<div class="form-group">
									    <div class="col-sm-offset-5 col-sm-6">
									      	<button type="submit" class="mbr-buttons__btn btn btn-lg btn-danger">GUARDAR</button>
									    </div>
									</div>
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
</html>