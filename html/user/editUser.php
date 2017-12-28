<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<script src="views/app/js/user.js"></script>
<?php
	if(isset($_GET['success'])){
		if($_GET['success']==true){
			?>
				<script>
					swal(
						{title:'Usuario editado!',
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
						type:'error',
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
			                <div class="row">
			                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
			                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
			                            <h2 class="mbr-header__text">Editar Usuario</h2>
			                        </div>
			                        <p>Los campos con (*) son obligatorios.</p>
			                        <form id="user" method="post" action="?view=user&mode=edit&id=<?php echo $_GET['id'];?>">
			                        	<div class="form-group">
			                                <input type="text" class="form-control" name="user" id="user" placeholder="Usuario*" value="<?php echo $_users[$_GET['id']]['user'];?>" onkeypress="return deshabilitarteclas(event)">
			                            </div>
			                            <div class="form-group col-sm-2" style="padding-top: 5px;">
											PERFIL*
										</div>
										<div class="form-group col-sm-10">
									      	<select class="form-control" name="perfil" id="perfil">
									      		<option value="">Seleccione</option>
										        <?php
										        	foreach($_perfil as $perfil){
										        		if($perfil['id_perfil']==$_users[$_GET['id']]['id_perfil']){
										        			?>
											        			<option selected value="<?php echo $perfil['id_perfil']?>"><?php echo $perfil['perfil']?></option>
											        		<?php
										        		}else{
															?>
											        			<option value="<?php echo $perfil['id_perfil']?>"><?php echo $perfil['perfil']?></option>
											        		<?php
										        		}
										        	}
										        ?>
										    </select>
									    </div>
									    <div class="form-group col-sm-2" style="padding-top: 5px;">
											STATUS*
										</div>
										<div class="form-group col-sm-10">
									      	<select class="form-control" name="status" id="status">
									      		<option value="">Seleccione</option>
										        <?php
										        	foreach($_status as $status){
										        		if($status['id_status']==$_users[$_GET['id']]['id_status']){
										        			?>
											        			<option selected value="<?php echo $status['id_status']?>"><?php echo $status['status']?></option>
											        		<?php
										        		}else{
															?>
											        			<option value="<?php echo $status['id_status']?>"><?php echo $status['status']?></option>
											        		<?php
										        		}
										        	}
										        ?>
										    </select>
									    </div>
									    <div class="form-group">
			                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="NOMBRE*" value="<?php echo $_users[$_GET['id']]['nombre'];?>">
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