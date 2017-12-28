<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<script src="views/app/js/beneficiario.js"></script>
<?php
	if(isset($_GET['success'])){
		if($_GET['success']==true){
			?>
				<script>
					swal(
						{title:'Beneficiario editado!',
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
	<body>
		<div class="container-fluid">
			<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-7" style="margin-left: 180px;">
    		    <div class="mbr-section__container mbr-section__container--std-padding container" style="padding-top: 93px; padding-bottom: 93px;">
			        <div class="row">
			            <div class="col-sm-12">
			            	<div class="col-md-2">
								<a class="btn btn-danger" href="?view=beneficiario"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
							</div>
			                <div class="row">
			                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
			                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
			                            <h2 class="mbr-header__text">EDITAR BENEFICIARIO</h2>
			                        </div>
			                        <p>Los campos con (*) son obligatorios.</p>
			                        <form id="beneficiaro" method="post" action="?view=beneficiario&mode=edit&id=<?php echo $_GET['id']?>">
			                            <div class="form-group">
			                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="NOMBRE*" value="<?php echo $_beneficiario[$_GET['id']]['nombre'];?>">
			                            </div>
										<div class="form-group">
				                            <input type="text" class="form-control" id="rif" name="rif" placeholder="RIF*" onkeypress="return solonumeros2(event)" maxlength="13" value="<?php echo $_beneficiario[$_GET['id']]['rif'];?>">
										</div>
										<div class="form-group col-sm-2">
									      	<select class="form-control" name="cod_tlf" id="cod_tlf">
									      		<option value="">Seleccione</option>
										        <?php
										        	foreach($_cod_tlf as $tlf){
										        		if($tlf['id_cod_tlf']==$_beneficiario[$_GET['id']]['id_cod_tlf']){
										        			?>
										        				<option selected value="<?php echo $tlf['id_cod_tlf']?>"><?php echo $tlf['cod_tlf']?></option>
										        			<?php
										        		}else{
										        			?>
											        			<option value="<?php echo $tlf['id_cod_tlf']?>"><?php echo $tlf['cod_tlf']?></option>
											        		<?php
										        		}
										        	}
										        ?>
										    </select>
									    </div>
			                            <div class="form-group col-sm-10">
			                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="TELEFONO*" maxlength="7" onkeypress="return solonumeros(event)" value="<?php echo $_beneficiario[$_GET['id']]['telefono'];?>">
			                            </div>
			                            <div class="form-group col-sm-2">
									      	<select class="form-control" name="cod_tlf2" id="cod_tlf2">
									      		<option value="">Seleccione</option>
										        <?php
										        	foreach($_cod_tlf as $tlf){
										        		if($tlf['id_cod_tlf']==$_beneficiario[$_GET['id']]['id_cod_tlf2']){
										        			?>
										        				<option selected value="<?php echo $tlf['id_cod_tlf']?>"><?php echo $tlf['cod_tlf']?></option>
										        			<?php
										        		}else{
										        			?>
											        			<option value="<?php echo $tlf['id_cod_tlf']?>"><?php echo $tlf['cod_tlf']?></option>
											        		<?php
										        		}
										        	}
										        ?>
										    </select>
									    </div>
			                            <div class="form-group col-sm-10">
			                                <input type="text" class="form-control" id="telefono2" name="telefono2" placeholder="OTRO TELEFONO" maxlength="7" onkeypress="return solonumeros(event)" value="<?php echo $_beneficiario[$_GET['id']]['telefono2'];?>">
			                            </div>
			                            <div class="form-group">
			                                <input type="text" class="form-control" name="correo" id="correo" placeholder="CORREO" value="<?php echo $_beneficiario[$_GET['id']]['correo'];?>">
			                            </div>
			                            <div class="form-group">
			                                <textarea class="form-control" id="direccion" name="direccion" rows="7" placeholder="DIRECCION*"><?php echo $_beneficiario[$_GET['id']]['direccion']?></textarea>
			                            </div>
			                             <div class="form-group">
			                                <input type="text" class="form-control" name="contacto" id="contacto" placeholder="PERSONA CONTACTO*" value="<?php echo $_beneficiario[$_GET['id']]['contacto'];?>">
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