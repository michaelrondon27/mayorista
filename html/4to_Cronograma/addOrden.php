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
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                    	<div class="col-md-12">
									<a class="btn btn-danger" href="?view=4toCronograma&mode=allCotizacion"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
								</div>
								<br>
								<br>
		                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">GENERAR ORDEN DE DESPACHO A LA COTIZACIÓN <?php echo $_cotizacion4to[$_GET['id']]['cotizacion'];?> del 4to Cronograma</h2>
		                        </div>
		                        <p>Los campos con (*) son obligatorios.</p>
		                        <form class="form-horizontal" method="POST" action="?view=4toCronograma&mode=addOrden&id=<?php echo $_GET['id'];?>">
									<input type="hidden" id="art1" value="1">
		                            <div class="form-group">
				  						<div class="col-sm-3">
											<label>*Orden de Despacho:</label>
										</div>
									    <div class="col-sm-8">
											<input type="text" class="form-control" id="orden" name="orden">
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
		                            <div class="form-group">
		                            	<div class="col-sm-1">
											<label for="tipo" class="col-sm-2 control-label">*1:</label>
										</div>
									    <div class="col-sm-3">
									      	<select class="form-control" name="pago1" id="pago1">
									      		<option value="">Seleccione</option>
										        <option value="C">Cr&eacute;dito</option>
										        <option value="D">Dep&oacute;sito</option>
										        <option value="T">Transferencia</option>
										    </select>
									    </div>
									    <div class="col-sm-3">
											<input type="text" class="form-control" id="factura1" name="factura1" disabled onkeypress="return solonumeros(event)" maxlength="10">
										</div>
										<div class="col-sm-4">
											<select class="form-control" name="contado1" id="contado1" disabled>
									      		<option value="">Seleccione</option>
										        <option value="Banco de Venezuela">Banco de Venezuela</option>
										        <option value="Banco Bicentenario">Banco Bicentenario</option>
										    </select>
										</div>
									</div>
									<div class="form-group">
		                            	<div class="col-sm-1">
											<label for="tipo" class="col-sm-2 control-label">2:</label>
										</div>
									    <div class="col-sm-3">
									      	<select class="form-control" name="pago2" id="pago2">
									      		<option value="">Seleccione</option>
										        <option value="C">Cr&eacute;dito</option>
										        <option value="D">Dep&oacute;sito</option>
										        <option value="T">Transferencia</option>
										    </select>
									    </div>
									    <div class="col-sm-3">
											<input type="text" class="form-control" id="factura2" name="factura2" disabled onkeypress="return solonumeros(event)" maxlength="10">
										</div>
										<div class="col-sm-4">
											<select class="form-control" name="contado2" id="contado2" disabled>
									      		<option value="">Seleccione</option>
										        <option value="Banco de Venezuela">Banco de Venezuela</option>
										        <option value="Banco Bicentenario">Banco Bicentenario</option>
										    </select>
										</div>
									</div>
									<div class="form-group">
		                            	<div class="col-sm-1">
											<label for="tipo" class="col-sm-2 control-label">3:</label>
										</div>
									    <div class="col-sm-3">
									      	<select class="form-control" name="pago3" id="pago3">
									      		<option value="">Seleccione</option>
										        <option value="C">Cr&eacute;dito</option>
										        <option value="D">Dep&oacute;sito</option>
										        <option value="T">Transferencia</option>
										    </select>
									    </div>
									    <div class="col-sm-3">
											<input type="text" class="form-control" id="factura3" name="factura3" disabled onkeypress="return solonumeros(event)" maxlength="10">
										</div>
										<div class="col-sm-4">
											<select class="form-control" name="contado3" id="contado3" disabled>
									      		<option value="">Seleccione</option>
										        <option value="Banco de Venezuela">Banco de Venezuela</option>
										        <option value="Banco Bicentenario">Banco Bicentenario</option>
										    </select>
										</div>
									</div>
									<div class="form-group">
		                            	<div class="col-sm-1">
											<label for="tipo" class="col-sm-2 control-label">4:</label>
										</div>
									    <div class="col-sm-3">
									      	<select class="form-control" name="pago4" id="pago4">
									      		<option value="">Seleccione</option>
										        <option value="C">Cr&eacute;dito</option>
										        <option value="D">Dep&oacute;sito</option>
										        <option value="T">Transferencia</option>
										    </select>
									    </div>
									    <div class="col-sm-3">
											<input type="text" class="form-control" id="factura4" name="factura4" disabled onkeypress="return solonumeros(event)" maxlength="10">
										</div>
										<div class="col-sm-4">
											<select class="form-control" name="contado4" id="contado4" disabled>
									      		<option value="">Seleccione</option>
										        <option value="Banco de Venezuela">Banco de Venezuela</option>
										        <option value="Banco Bicentenario">Banco Bicentenario</option>
										    </select>
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