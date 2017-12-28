<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
	$db=new Conexion();
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
<script>
	$(document).ready(function(){
		$("#prod1").change(function(){
		    var prod=$("#prod1").val();
		    var art=$("#art1").val();
		    var alma=$("#alma1").val();
		    var valor=5;
		    if(alma!=""){
		        $.ajax({
		            type: "POST",
		            url: "core/controllers/buscarController.php",
		            data:{
		                "prod":prod,
		                "art":art,
		                "alma":alma,
		                "valor":valor
		            },
			        success: function(resp){
			            if(resp!=""){
			                $("#disponible1").html(resp);
			            }
			        }
			    });
			}else{
			    swal(
			        {title:'Por favor, seleccione una almacenadora!',
			        type:'warning',
			        confirmButtonText:'Cerrar'}
			    );
			    document.getElementById("prod1").value="";
			}       
	    });
	});
</script>
<body>
	<div class="container-fluid">
		<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-7" style="margin-left: 180px;">
   		    <div class="mbr-section__container mbr-section__container--std-padding container" style="padding-top: 93px; padding-bottom: 93px;">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">EDITAR PRODUCTO A LA COTIZACIÓN <?php echo $_cotizacionJuguetes[$_GET['id']]['cotizacion'];?> de Juguetes</h2>
		                        </div>
		                        <p>Los campos con (*) son obligatorios.</p>
		                        <form class="form-horizontal" method="POST" action="?view=Juguetes&mode=editProducto&id=<?php echo $_GET['id'];?>&orden=<?php echo $_GET['orden'];?>">
		                       		<?php
		                       			$orden=$_GET['orden'];
										$sql=$db->query("SELECT id_almacenadora, id_producto, cantidad, precio_num FROM ordenes_juguetes WHERE id_ordenes=$orden LIMIT 1;");
										$data=$db->recorrer($sql);
									?>
									<input type="hidden" id="art1" value="1">
									<input type="hidden" name="alma_o" value="<?php echo $data[0];?>">
									<input type="hidden" name="prod_o" value="<?php echo $data[1];?>">
									<input type="hidden" name="cant_o" value="<?php echo $data[2];?>">
									<input type="hidden" name="precio_o" value="<?php echo $data[3];?>">
		                            <div class="form-group">
				  						<div class="col-sm-2">
											<label>*Almacenadora:</label>
										</div>
									    <div class="col-sm-8">
											<select class="form-control" id="alma1" name="alma1">
												<option value="">Seleccione</option>
											   	<?php
											   		foreach ($_almacenadorasJuguetes as $almacenadorasJuguetes) {
											   			if($almacenadorasJuguetes['id_almacenadora']==1){
										        			?>
											        			<option selected value="<?php echo $almacenadorasJuguetes['id_almacenadora'];?>"><?php echo $almacenadorasJuguetes['nombre'];?></option>
											        		<?php
										        		}else{
										        			?>
											        			<option value="<?php echo $almacenadorasJuguetes['id_almacenadora'];?>"><?php echo $almacenadorasJuguetes['nombre'];?></option>
											        		<?php
										        		}
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
											   		foreach ($_productoJuguetes as $producto) {
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
</html>