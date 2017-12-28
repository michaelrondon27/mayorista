<?php
	if(isset($_POST['productos'])){
	$productos=$_POST['productos'];
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'mayorista');
	require('../../core/models/classConexion.php');
	require('../../core/bin/functions/Almacenadoras4to.php');
	require('../../core/bin/functions/Productos4to.php');
	$_almacenadoras4to=Almacenadoras4to();
	$_producto4to=Productos4to();
?>
<script src="views/app/js/calculo4to.js"></script>
<input type="hidden" id="productos" name="productos" value="<?php echo $productos;?>">
<table class="table table-bordered" id="mitabla">
	<tr>
		<td>ITEM</td>
		<td>ALMACENADORA</td>
		<td>PRODUCTO</td>
		<td>MODELO</td>
		<td>CANTIDAD</td>
		<td>PRECIO TOTAL</td>
	</tr>
	<?php
		for($i=1;$i<=$productos;$i++){
			?>
			<tr>
				<td><?php echo $i;?></td>
				<input type="hidden" id="art<?php echo $i;?>" value="<?php echo $i;?>">
				<td>
					<div class="col-sm-12">
				   		<select class="form-control" id="alma<?php echo $i;?>" name="alma<?php echo $i;?>">
				   			<option value="">Seleccione</option>
					        <?php
					        	foreach ($_almacenadoras4to as $almacenadoras4to) {
					        		?>
					        			<option value="<?php echo $almacenadoras4to['id_almacenadora'];?>"><?php echo $almacenadoras4to['nombre'];?></option>
					        		<?php
					        	}
							?>
						</select>
					</div>
				</td>
				<td>
					<div class="col-sm-12">
				   		<select class="form-control" id="prod<?php echo $i;?>" name="prod<?php echo $i;?>">
				   			<option value="">Seleccione</option>
				        	<?php
							    foreach ($_producto4to as $producto4to) {
					        		?>
					        			<option value="<?php echo $producto4to['id_producto'];?>"><?php echo $producto4to['producto'];?></option>
					        		<?php
					        	}
					        ?>
					  	</select>
					</div>
				</td>
				<td>
					<div class="col-sm-12">
						<select class="form-control" id="modelo<?php echo $i;?>" name="mod<?php echo $i;?>" >
							<option value="">Seleccione</option>
						</select>
					</div>
				</td>
				<td>
					<div class="col-sm-12" id="disponible<?php echo $i;?>"></div>		
				</td>
				<td>
					<div class="col-sm-12">
				    	<input type="text" class="form-control" id="subtotal<?php echo $i;?>" name="subtotal<?php echo $i;?>" onkeypress="return deshabilitarteclas(event)">
				    	<input type="hidden" class="form-control" id="sub<?php echo $i;?>" name="sub<?php echo $i;?>">
					</div>
				</td>
			</tr>
			<?php
		}
	?>
	<tr>
					<td colspan="4" align="right">
						<strong>CANTIDAD TOTAL</strong>
					</td>
					<td colspan="2">
						<div class="col-sm-6">
					    	<input type="text" class="form-control" id="uni_total"
					    	name="uni_total" onkeypress="return deshabilitarteclas(event)" value="0">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="5" align="right">
						<strong>SUBTOTAL</strong>
					</td>
					<td>
						<div class="col-sm-12">
					    	<input type="hidden" class="form-control" id="subtotal_num"
					    	name="subtotal_num">
					    	<input type="text" class="form-control" id="subtot"
					    	name="subtot" onkeypress="return deshabilitarteclas(event)">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="right">
						<strong>Descuento</strong>
					</td>
					<td>
						<div class="col-sm-12">
					    	<input type="text" class="form-control" id="descuento" name="descuento" onkeypress="return solonumeros(event)">
						</div>
					</td>
					<td>
						<div class="col-sm-12">
					    	<input type="text" class="form-control" id="descuento2" name="descuento2" onkeypress="return deshabilitarteclas(event)" size="2">
					    	<input type="hidden" class="form-control" id="desc_num"
					    	name="desc_num">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="5" align="right">
						<strong>TOTAL</strong>
					</td>
					<td>
						<div class="col-sm-12">
					    	<input type="text" class="form-control" id="total" name="total" onkeypress="return deshabilitarteclas(event)">
					    	<input type="hidden" class="form-control" id="total_num" name="total_num">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="6" align="center">
						<div class="form-group">	
							<button type="submit" class="btn btn-danger">GUARDAR</button>
						</div>
					</td>
				</tr>
			</table>
		<?php
	}
?>