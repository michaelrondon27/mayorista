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
						{title:'Contraseña Cambiada!',
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
		}else if($_GET['error']==2){
			?>
				<script>
					swal(
						{title:'Las contraseñas no coinciden!',
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
			                <div class="row">
			                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
			                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
			                            <h2 class="mbr-header__text">Admin Password Usuario</h2>
			                        </div>
			                        <p>Los campos con (*) son obligatorios.</p>
			                        <form id="user" method="post" action="?view=user&mode=adminPass&id=<?php echo $_GET['id'];?>">
			                        	<div class="form-group">
			                                <input type="text" class="form-control" name="user" id="user" placeholder="Usuario*" value="<?php echo $_users[$_GET['id']]['user'];?>" onkeypress="return deshabilitarteclas(event)">
			                            </div>
			                            <div class="form-group">
				                            <input type="password" class="form-control" id="pass" name="pass" placeholder="CONTRASEÑA*">
										</div>
										<div class="form-group">
				                            <input type="password" class="form-control" id="repeat" name="repeat" placeholder="REPETIR CONTRASEÑA*">
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