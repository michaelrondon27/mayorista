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
		}else if($_GET['error']==2){
			?>
				<script>
					swal(
						{title:'El número de orden de despacho ya esta registrado en el sistema!',
						type:'warning',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
	}
	if(isset($_GET['success'])){
		if($_GET['success']==1){
			?>
				<script>
					swal(
						{title:'Orden de despacho editada!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==2){
			?>
				<script>
					swal(
						{title:'Pago agregado!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}else if($_GET['success']==3){
			?>
				<script>
					swal(
						{title:'Pago eliminado!',
						type:'success',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}

	}
?>
<script>
	$(document).ready(function(){
		$("#pago1").change(function(){
			var pago=$("#pago1").val();
			if(pago==""){
				$("#factura1").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado1").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="C"){
				$("#factura1").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado1").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="D"){
				$("#factura1").attr("disabled", false).focus().attr("class", "required").attr("class", "form-control").attr("title", " ");
				$("#contado1").attr("disabled", false).focus().attr("class", "required").attr("class", "form-control").attr("title", " ");
			}else if(pago=="T"){
				$("#factura1").attr("disabled", false).focus().attr("class", "required").attr("class", "form-control").attr("title", " ");
				$("#contado1").attr("disabled", false).focus().attr("class", "required").attr("class", "form-control").attr("title", " ");
			}
		});
		$("#pago2").change(function(){
			var pago=$("#pago2").val();
			if(pago==""){
				$("#factura2").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado2").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="C"){
				$("#factura2").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado2").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="D"){
				$("#factura2").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado2").attr("disabled", false).focus().attr("class", "form-control");
			}else if(pago=="T"){
				$("#factura2").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado2").attr("disabled", false).focus().attr("class", "form-control");
			}
		});
		$("#pago3").change(function(){
			var pago=$("#pago3").val();
			if(pago==""){
				$("#factura3").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado3").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="C"){
				$("#factura3").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado3").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="D"){
				$("#factura3").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado3").attr("disabled", false).focus().attr("class", "form-control");
			}else if(pago=="T"){
				$("#factura3").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado3").attr("disabled", false).focus().attr("class", "form-control");
			}
		});
		$("#pago4").change(function(){
			var pago=$("#pago4").val();
			if(pago==""){
				$("#factura4").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado4").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="C"){
				$("#factura4").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado4").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="D"){
				$("#factura4").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado4").attr("disabled", false).focus().attr("class", "form-control");
			}else if(pago=="T"){
				$("#factura4").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado4").attr("disabled", false).focus().attr("class", "form-control");
			}
		});
		$("#pago").change(function(){
			var pago=$("#pago").val();
			if(pago==""){
				$("#factura").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="C"){
				$("#factura").attr("disabled", true).val("").attr("class", "form-control");
				$("#contado").attr("disabled", true).val("").attr("class", "form-control");
			}else if(pago=="D"){
				$("#factura").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado").attr("disabled", false).focus().attr("class", "form-control");
			}else if(pago=="T"){
				$("#factura").attr("disabled", false).focus().attr("class", "form-control");
				$("#contado").attr("disabled", false).focus().attr("class", "form-control");
			}
		});
		$("#form_orden").validate({
			rules:{
				orden:"required",
				pago1:"required",
				factura1:[10,11]
			},
			messages:{
				orden:"",
				pago1:"",
				factura1:"M&iacute;nimo 10 caracteres"
			}
		});
	});
</script>
<body class="fondo">
	<div class="container-fluid">
		<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-7" style="margin-left: 180px;">
   		    <div class="mbr-section__container mbr-section__container--std-padding container" style="padding-top: 93px; padding-bottom: 93px;">
		        <div class="row">
		            <div class="col-sm-12">
		            	<div class="col-md-12">
							<a class="btn btn-danger" href="?view=4toCronograma&mode=allCotizacion"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
						</div>
						<br>
						<br>
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">EDITAR ORDEN DE DESPACHO A LA COTIZACIÓN <?php echo $_cotizacion4to[$_GET['id']]['cotizacion'];?> del 4to Cronograma</h2>
		                        </div>
		                        <p>Los campos con (*) son obligatorios.</p>
		                        <form class="form-horizontal" method="POST" action="?view=4toCronograma&mode=editOrden&id=<?php echo $_GET['id'];?>">
									<input type="hidden" id="art1" value="1">
		                            <div class="form-group">
				  						<div class="col-sm-3">
											<label>*Orden de Despacho:</label>
										</div>
									    <div class="col-sm-8">
											<input type="text" class="form-control" id="orden" name="orden" value="<?php echo $_despacho4to[$_cotizacion4to[$_GET['id']]['id_cotizacion']]['despacho']?>">
										</div>
									</div>
									<div class="form-group">
				  						<div class="col-sm-2">
											<label>Beneficiario:</label>
										</div>
									    <div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $_beneficiario[$_cotizacion4to[$_GET['id']]['id_empresa']]['nombre'];?>" onkeypress="return deshabilitarteclas(event)">
										</div>
									</div>
									<?php 
										$id_cotizacion=$_GET['id'];
										$sql=$db->query("SELECT pago, deposito, banco, id_despacho FROM despacho_4to WHERE id_cotizacion=$id_cotizacion");
										$contador=1;
										while($data=$db->recorrer($sql)){
											?>
												<div class="form-group">
					                            	<div class="col-sm-1">
														<label for="tipo" class="col-sm-2 control-label"><?php echo $contador?>:</label>
													</div>
													<input type="hidden" name="id_despacho<?php echo $contador?>" value="<?php echo $data[3];?>">
												    <div class="col-sm-3">
												      	<select class="form-control" name="pago<?php echo $contador?>" id="pago<?php echo $contador?>">
												      		<?php
												      			if($data[0]=='C'){
												      				?>
												      					<option value="">Seleccione</option>
																        <option selected value="C">Cr&eacute;dito</option>
																        <option value="D">Dep&oacute;sito</option>
																        <option value="T">Transferencia</option>
												      				<?php
												      			}else if($data[0]=='D'){
												      				?>
												      					<option value="">Seleccione</option>
																        <option value="C">Cr&eacute;dito</option>
																        <option selected value="D">Dep&oacute;sito</option>
																        <option value="T">Transferencia</option>
												      				<?php
												      			}else if($data[0]=='T'){
												      				?>
												      					<option value="">Seleccione</option>
																        <option value="C">Cr&eacute;dito</option>
																        <option value="D">Dep&oacute;sito</option>
																        <option selected value="T">Transferencia</option>
												      				<?php
												      			}else{
												      				?>
												      					<option value="">Seleccione</option>
																        <option value="C">Cr&eacute;dito</option>
																        <option value="D">Dep&oacute;sito</option>
																        <option value="T">Transferencia</option>
												      				<?php
												      			}
												      		?>
													    </select>
												    </div>
												    <?php
												    	if($data[0]=='C'){
												    		?>
												    			<div class="col-sm-3">
																	<input type="text" class="form-control" id="factura<?php echo $contador?>" name="factura<?php echo $contador?>" disabled onkeypress="return solonumeros(event)" maxlength="10">
																</div>
												    		<?php
												    	}else{
												    		?>
												    			<div class="col-sm-3">
																	<input type="text" class="form-control" id="factura<?php echo $contador?>" name="factura<?php echo $contador?>" onkeypress="return solonumeros(event)" maxlength="10" value="<?php echo $data[1]?>">
																</div>
												    		<?php
												    	}
												    ?>
												    <?php
												    	if($data[0]=='C'){
												    		?>
												    			<div class="col-sm-4">
																	<select class="form-control" name="contado<?php echo $contador?>" id="contado<?php echo $contador?>" disabled>
															      		<option value="">Seleccione</option>
																        <option value="Banco de Venezuela">Banco de Venezuela</option>
																        <option value="Banco Bicentenario">Banco Bicentenario</option>
																    </select>
																</div>
												    		<?php
												    	}else{
												    		if($data[2]=="Banco de Venezuela"){
												    			?>
													    			<div class="col-sm-4">
																		<select class="form-control" name="contado<?php echo $contador?>" id="contado<?php echo $contador?>">
																      		<option value="">Seleccione</option>
																	        <option selected value="Banco de Venezuela">Banco de Venezuela</option>
																	        <option value="Banco Bicentenario">Banco Bicentenario</option>
																	    </select>
																	</div>
													    		<?php
												    		}else if($data[2]=="Banco Bicentenario"){
												    			?>
													    			<div class="col-sm-4">
																		<select class="form-control" name="contado<?php echo $contador?>" id="contado<?php echo $contador?>">
																      		<option value="">Seleccione</option>
																	        <option value="Banco de Venezuela">Banco de Venezuela</option>
																	        <option selected value="Banco Bicentenario">Banco Bicentenario</option>
																	    </select>
																	</div>
													    		<?php
												    		}
												    		
												    	}
												    ?>
												    <div class="form-group">
												    	<a class="btn btn-danger" onclick="DeleteItem('¿Está seguro de eliminar este pago?','?view=4toCronograma&mode=deletePago&id=<?php echo $_cotizacion4to[$_GET['id']]['id_cotizacion'];?>&id_despacho=<?php echo $data[3];?>')">Eliminar</a>
												    </div>
												</div>
											<?php
											$contador++;
										}
									?>
									<input type="hidden" name="contador" value="<?php echo $contador;?>">
									<div class="mbr-buttons mbr-buttons--center"><button type="submit" class="mbr-buttons__btn btn btn-lg btn-danger">GUARDAR</button></div>
		                        </form>
		                        <br>
		                        <br>
		                        <?php
									$add=5-$contador;
									if($add>0){
										?>
											<div class="mbr-header mbr-header--center mbr-header--std-padding">
					                            <h2 class="mbr-header__text">AGREGAR PAGO A LA COTIZACIÓN <?php echo $_cotizacion4to[$_GET['id']]['cotizacion'];?> del 4to Cronograma</h2>
					                        </div>
											<form class="form-horizontal" method="POST" action="?view=4toCronograma&mode=addPago&id=<?php echo $_GET['id'];?>">
												<div class="form-group">
					                            	<div class="col-sm-1">
														<label for="tipo" class="col-sm-2 control-label">Nuevo:</label>
													</div>
												    <div class="col-sm-3">
												      	<select class="form-control" name="pago" id="pago">
												      		<option value="">Seleccione</option>
													        <option value="C">Cr&eacute;dito</option>
													        <option value="D">Dep&oacute;sito</option>
													        <option value="T">Transferencia</option>
													    </select>
												    </div>
												    <div class="col-sm-3">
														<input type="text" class="form-control" id="factura" name="factura" disabled onkeypress="return solonumeros(event)" maxlength="10">
													</div>
													<div class="col-sm-4">
														<select class="form-control" name="contado" id="contado" disabled>
												      		<option value="">Seleccione</option>
													        <option value="Banco de Venezuela">Banco de Venezuela</option>
													        <option value="Banco Bicentenario">Banco Bicentenario</option>
													    </select>
													</div>
												</div>
												<input type="hidden" class="form-control" id="orden" name="orden" value="<?php echo $_despacho4to[$_cotizacion4to[$_GET['id']]['id_cotizacion']]['despacho']?>">
												<div class="mbr-buttons mbr-buttons--center"><button type="submit" class="mbr-buttons__btn btn btn-lg btn-danger">GUARDAR</button></div>
		                        			</form>
											<?php
										}
									?>
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