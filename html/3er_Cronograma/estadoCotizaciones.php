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
						{title:'no hay nada que reportar!',
						type:'warning',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
	}
?>
<link rel="stylesheet" href="views/app/css/jquery-ui.css">
<script src="views/app/js/jquery-ui.js"></script>
<script>
	$(document).ready(function(){
		$("#desde").datepicker({
		    changeMonth: true
		});
		$("#hasta").datepicker({
		    changeMonth: true
		});
		$("#desde1").datepicker({
		    changeMonth: true
		});
		$("#hasta1").datepicker({
		    changeMonth: true
		});
		$("#financiero").validate({
			rules:{
				desde:"required",
				hasta:"required",
				desde1:"required",
				hasta1:"required"
			},
			messages:{
				desde:"",
				hasta:"",
				desde1:"",
				hasta1:""
			}
		});
	});
</script>
	<div class="container-fluid ">
		<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-7" style="margin-left: 180px;">
   		    <div class="mbr-section__container mbr-section__container--std-padding container" style="padding-top: 93px; padding-bottom: 93px;">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2" data-form-type="formoid">
		                        <div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">REPORTE DE COTIZACIONES (PDF)</h2>
		                        </div>
		                        <p>Los campos con (*) son obligatorios.</p>
		                        <form class="form-horizontal" id="financiero" method="POST" action="?view=3erCronograma&mode=estadoCotizaciones&tipo=pdf">
				  					<div class="form-group">
				  						<div class="col-sm-1"></div>
									    <label for="nombre" class="col-sm-2 control-label">*DESDE:</label>
									    <div class="col-sm-5">
									    	<input type="text" class="form-control" id="desde" name="desde" autocomplete="off">
									    </div>
									    <div class="col-sm-4"></div>
									</div>
									<div class="form-group">
										<div class="col-sm-1"></div>
									    <label for="rif" class="col-sm-2 control-label">*HASTA:</label>
									    <div class="col-sm-5">
									    	<input type="text" class="form-control" id="hasta" name="hasta" autocomplete="off">
									    </div>
									    <div class="col-sm-4"></div>
									</div>
									<div class="form-group">
									    <div class="col-sm-offset-3 col-sm-5">
									      	<button type="submit" class="btn btn-danger">GENERAR PDF</button>
									    </div>
									</div>
								</form>
								<br>
								<div class="mbr-header mbr-header--center mbr-header--std-padding">
		                            <h2 class="mbr-header__text">REPORTE DE COTIZACIONES (EXCEL)</h2>
		                        </div>
		                        <p>Los campos con (*) son obligatorios.</p>
		                        <form class="form-horizontal" id="financiero" method="POST" action="?view=3erCronograma&mode=estadoCotizaciones&tipo=excel">
				  					<div class="form-group">
				  						<div class="col-sm-1"></div>
									    <label for="nombre" class="col-sm-2 control-label">*DESDE:</label>
									    <div class="col-sm-5">
									    	<input type="text" class="form-control" id="desde1" name="desde" autocomplete="off">
									    </div>
									    <div class="col-sm-4"></div>
									</div>
									<div class="form-group">
										<div class="col-sm-1"></div>
									    <label for="rif" class="col-sm-2 control-label">*HASTA:</label>
									    <div class="col-sm-5">
									    	<input type="text" class="form-control" id="hasta1" name="hasta" autocomplete="off">
									    </div>
									    <div class="col-sm-4"></div>
									</div>
									<div class="form-group">
									    <div class="col-sm-offset-3 col-sm-5">
									      	<button type="submit" class="btn btn-danger">GENERAR EXCEL</button>
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