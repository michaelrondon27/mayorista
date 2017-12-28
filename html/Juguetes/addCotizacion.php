<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<link rel="stylesheet" href="views/app/css/jquery-ui.css">
<script src="views/app/js/jquery-ui.js"></script>
<script src="views/app/js/cotizacion.js"></script>
<script>
	$(document).ready(function(){
		$("#datepicker").datepicker({
	        changeMonth: true
	    });
		$('#productos').change(function(){
			var producto=$('#productos').val();
			$.ajax({
	            type: "POST",
	            url: "html/Juguetes/CantProd.php",
	            data:{
	            	"productos":producto
	            },
	            success: function(resp){
                    if(resp!=""){
                        $("#respuestas").html(resp);
                    }
                }
	        });
		});
	});
</script>
<?php
	if(isset($_GET['success'])){
		if($_GET['success']==true){
			?>
				<script>
					swal(
						{title:'Cotización guardada!',
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
		}else if($_GET['error']==2){
			?>
				<script>
					swal(
						{title:'Este numero de cotización ya se encuentra registrado!',
						type:'warning',
						confirmButtonText:'Aceptar'}
					);
				</script>
			<?php
		}
	}
?>
<body class="fondo">
	<div class="">
		<div class="container" style="margin-left: 180px; padding-top: 40px;">
			<h4 class="col-md-12" align="center">COTIZACI&Oacute;N Juguetes</h4>
			<form class="form-horizontal" method="post" action="?view=Juguetes&mode=addCotizacion" id="form_cotizacion">
				<input type="hidden" name="mode" value="add">
					<div class="form-group">
						<label for="cotizacion" class="col-sm-2 control-label"><strong>Cotizaci&oacute;n Nro.:</strong></label>
					    <div class="col-sm-2">
					      <input type="text" class="form-control" id="cotizacion" name="cotizacion" required>
					    </div>
						<label class="col-sm-1 control-label"><strong>Fecha: </strong></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="datepicker" name="fecha" autocomplete="off">
						</div>
						<label for="empresa" class="col-sm-2 control-label"><strong>BENEFICIARIO:</strong></label>
					    <div class="col-sm-3">
					      	<select class="form-control" name="empresa" id="empresa">
					      		<option value="">Seleccione</option>
						        <?php
							    	foreach ($_beneficiario as $beneficiario) {
							    		?>
							    			<option value="<?php echo $beneficiario['id_empresa']?>"><?php echo $beneficiario['nombre'];?></option>
							    		<?php
							    	}
							    ?>
						    </select>
					    </div>
					</div>
					<div class="row">
						<div class="col-md-3">
							Cantidad de Productos a cotizar:
						</div>
						<div class="col-md-2">
							<select class="form-control" name="productos" id="productos">
								<option value="0">Seleccione</option>
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="30">30</option>
								<option value="40">40</option>
								<option value="50">50</option>
								<option value="60">60</option>
								<option value="70">70</option>
								<option value="80">80</option>
								<option value="90">90</option>
								<option value="100">100</option>
							</select>
						</div>
					</div>
					<br>
					<div id="respuestas"></div>
				</form>
			</div>
		</div>
		<?php
			//include(HTML_DIR."overall/footer.php");
		?>
	</body>
</html>