<?php
	class Juguetes{
		private $db;
		private $beneficiario;
		private $fecha;
		private $cotizacion;
		private $id_cotizacion;
		private $almacenadora;
		private $producto;
		private $cantidad;
		private $precio;
		private $descuento;
		private $id_orden;
		private $almacenadora_original;
		private $producto_original;
		private $cantidad_original;
		private $precio_original;
		private $orden;
		private $pago;
		private $factura;
		private $contado;
		private $id_despacho;
		private $contador;
		public function __construct(){
			$this->db=new Conexion();
		}
		public function EditCotizacion($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->cotizacion=$this->db->real_escape_string($_POST['cotizacion']);
			$this->beneficiario=$this->db->real_escape_string($_POST['empresa']);
			$this->fecha=$this->db->real_escape_string($_POST['fecha']);
			$this->fecha=date("Y-m-d", strtotime($this->fecha));
			$this->usuario=$usuario;
			$this->db->query("UPDATE cotizacion_juguetes SET cotizacion='$this->cotizacion', id_empresa='$this->beneficiario', fecha='$this->fecha' WHERE id_cotizacion=$this->id_cotizacion LIMIT 1");
			$indicesServer = array('REMOTE_ADDR',);
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Actualizo la cotizacion de Juguetes: ".$this->cotizacion.", con fecha: ".$this->fecha." y el id del beneficiario: ".$this->beneficiario;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
			header("location: ?view=Juguetes&mode=editCotizacion&id=".$this->id_cotizacion."&success=1");
		}
		public function DeleteCotizacion($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->usuario=$usuario;
			$sql=$this->db->query("SELECT o.id_producto, o.cantidad, c.cotizacion, o.id_almacenadora FROM ordenes_juguetes o INNER JOIN cotizacion_juguetes c ON o.id_cotizacion=c.id_cotizacion WHERE o.id_cotizacion=$this->id_cotizacion;");
			if($this->db->rows($sql)>0){
				while($data=$this->db->recorrer($sql)){
					$sql1=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades+$data[1] WHERE id_producto=$data[0] AND id_almacenadora=$data[3]");
					$sql2=$this->db->query("INSERT INTO cotizaciones_eliminadas_juguetes(cotizacion, id_modelo, cantidad, fecha, ip, usuario) VALUES('$data[2]', $data[0], $data[1], NOW(), '$ip', '$this->usuario');");
				}
			}
			$sql3="DELETE FROM ordenes_juguetes WHERE id_cotizacion=$this->id_cotizacion;";
			$sql3.="DELETE FROM cotizacion_juguetes WHERE id_cotizacion=$this->id_cotizacion;";
			$this->db->multi_query($sql3);
			$this->db->liberar($sql);
			$this->db->liberar($sql1);
			$this->db->liberar($sql2);
			$this->db->liberar($sql3);
			$indicesServer = array('REMOTE_ADDR',);
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Elimino la cotizacion de Juguetes: ".$this->id_cotizacion.", con fecha: ".$this->fecha." y el id del beneficiario: ".$this->beneficiario;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'DELETE');");
			header("location: ?view=Juguetes&success=1");
		}
		public function AddProducto($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->almacenadora=$_POST['alma1'];
			$this->producto=$_POST['prod1'];
			$this->cantidad=$_POST['cant1'];
			$this->precio=$_POST['sub1'];
			$this->usuario=$usuario;
			$sql=$this->db->query("SELECT subtotal_num, desc_porcentaje FROM cotizacion_juguetes WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
			$data=$this->db->recorrer($sql);
			$pre=number_format($this->precio, 2, ",", ".");
			$pre=$pre." Bs.";
			$subtotal=$data[0]+$this->precio;
			$sub=number_format($subtotal, 2, ",", ".");
			$sub=$sub." Bs.";
			if($data[1]!=""){
				$descuento=$subtotal*$data[1]/100;
				$desc=number_format($descuento, 2, ",", ".");
				$desc=$desc." Bs.";
				$total=$subtotal-$descuento;
				$tot=number_format($total, 2, ",", ".");
				$tot=$tot." Bs.";
				$sql1=$this->db->query("UPDATE cotizacion_juguetes SET total='$tot', subtotal='$sub', total_num=$total, descuento='$desc', descuento_num=$descuento, subtotal_num=$subtotal, unidades_total=unidades_total+$this->cantidad WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
				$sql2=$this->db->query("INSERT INTO ordenes_juguetes(id_cotizacion, cantidad, precio_total, precio_num, id_almacenadora, id_producto) VALUES($this->id_cotizacion, $this->cantidad, '$pre', $this->precio, $this->almacenadora, $this->producto);");
				$sql3=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				$this->db->liberar($sql);
			}else{
				$sql1=$this->db->query("UPDATE cotizacion_juguetes SET total='$sub', subtotal='$sub', total_num=$subtotal, subtotal_num=$subtotal, unidades_total=unidades_total+$this->cantidad WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
				$sql2=$this->db->query("INSERT INTO ordenes_juguetes(id_cotizacion, cantidad, precio_total, precio_num, id_almacenadora, id_producto) VALUES($this->id_cotizacion, $this->cantidad, '$pre', $this->precio, $this->almacenadora, $this->producto);");
				$sql3=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				$this->db->liberar($sql);
			}
			$indicesServer = array('REMOTE_ADDR',);
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Agrego producto: ".$this->producto."; producto: ".$this->producto."; cantidad: ".$this->cantidad." y almacenadora: ".$this->almacenadora." a la cotizacion de Juguetes: ".$this->id_cotizacion;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
			header("location: ?view=Juguetes&mode=editCotizacion&id=".$this->id_cotizacion."&success=2");
		}
		public function AddDescuento($usuario){
			$this->usuario=$usuario;
			$this->descuento=$this->db->real_escape_string($_POST['descuento']);
			$this->id_cotizacion=intval($_GET['id']);
			if($this->descuento=="" || $this->descuento==0){
				$sql=$this->db->query("SELECT subtotal, subtotal_num FROM cotizacion_juguetes WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
				if($this->db->rows($sql)>0){
					$data=$this->db->recorrer($sql);
					$sql1=$this->db->query("UPDATE cotizacion_juguetes SET total='$data[0]', total_num=$data[1], descuento='', descuento_num=0, desc_porcentaje='' WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$indicesServer = array('REMOTE_ADDR',);
					$ip=$_SERVER['REMOTE_ADDR'];
					$evento="Elimino el descuento a la cotizacion del Juguetes: ".$this->id_cotizacion;
					$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
				}
			}else{
				$sql=$this->db->query("SELECT subtotal_num FROM cotizacion_juguetes WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
				if($this->db->rows($sql)>0){
					$data=$this->db->recorrer($sql);
					$desc_num=$data[0]*$this->descuento/100;
					$desc=number_format($desc_num, 2, ",", ".");
					$desc=$desc." Bs.";
					$total_num=$data[0]-$desc_num;
					$total=number_format($total_num, 2, ",", ".");
					$total=$total." Bs.";
					$sql1=$this->db->query("UPDATE cotizacion_juguetes SET total='$total', total_num=$total_num, descuento='$desc', descuento_num=$desc_num, desc_porcentaje='$this->descuento' WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$indicesServer = array('REMOTE_ADDR',);
					$ip=$_SERVER['REMOTE_ADDR'];
					$evento="Agrego un descuento de ".$this->descuento." a la cotizacion del Juguetes: ".$this->id_cotizacion;
					$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
				}
			}
			header("location: ?view=Juguetes&mode=editCotizacion&id=".$this->id_cotizacion."&success=3");
		}
		public function DeleteProducto($usuario){
			$this->usuario=$usuario;
			$this->id_cotizacion=intval($_GET['id']);
			$this->id_orden=intval($_GET['orden']);
			$sql=$this->db->query("SELECT id_producto, cantidad, precio_num, id_almacenadora FROM ordenes_juguetes WHERE id_ordenes=$this->id_orden LIMIT 1;");
			$data=$this->db->recorrer($sql);
			$sql1=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades+$data[1] WHERE id_almacenadora=$data[3] AND id_producto=$data[0] LIMIT 1;");
			$sql2=$this->db->query("SELECT total_num, subtotal_num, desc_porcentaje FROM cotizacion_juguetes WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
			$data2=$this->db->recorrer($sql2);
			if($data2[2]!=""){
				$subtotal=$data2[1]-$data[2];
				$sub=number_format($subtotal, 2, ",", ".");
				$sub=$sub." Bs.";
				$descuento=$subtotal*$data2[2]/100;
				$desc=number_format($descuento, 2, ",", ".");
				$desc=$desc." Bs.";
				$total=$subtotal-$descuento;
				$tot=number_format($total, 2, ",", ".");
				$tot=$tot." Bs.";
				$sql3=$this->db->query("UPDATE cotizacion_juguetes SET total='$tot', subtotal='$sub', total_num=$total, descuento='$desc', descuento_num=$descuento, subtotal_num=$subtotal, unidades_total=unidades_total-$data[1] WHERE id_cotizacion=$this->id_cotizacion;");
				$sql4=$this->db->query("DELETE FROM ordenes_juguetes WHERE id_ordenes=$this->id_orden LIMIT 1;");
				$ip=$_SERVER['REMOTE_ADDR'];
				$evento="elimino el producto de la cotizacion de juguetes: ".$this->id_cotizacion." con el id orden: ".$this->id_orden;
				$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'DELETE');");
			}else{
				$total=$data2[1]-$data[2];
				$tot=number_format($total, 2, ",", ".");
				$tot=$tot." Bs.";
				$sql3=$this->db->query("UPDATE cotizacion_juguetes SET total='$tot', subtotal='$tot', total_num=$total, subtotal_num=$total, unidades_total=unidades_total-$data[1] WHERE id_cotizacion=$this->id_cotizacion;");
				$sql4=$this->db->query("DELETE FROM ordenes_juguetes WHERE id_ordenes=$this->id_orden LIMIT 1;");
				$ip=$_SERVER['REMOTE_ADDR'];
				$evento="elimino el producto de la cotizacion de juguetes: ".$this->id_cotizacion." con el id orden: ".$this->id_orden;
				$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'DELETE');");
			}
			$this->db->liberar($sql);
			$this->db->liberar($sql2);
			header("location: ?view=Juguetes&mode=editCotizacion&id=".$this->id_cotizacion."&success=4");
		}
		public function EditProducto($usuario){
			$this->usuario=$usuario;
			$this->id_cotizacion=intval($_GET['id']);
			$this->id_orden=intval($_GET['orden']);
			$this->almacenadora_original=$_POST['alma_o'];
			$this->producto_original=$_POST['prod_o'];
			$this->cantidad_original=$_POST['cant_o'];
			$this->precio_original=$_POST['precio_o'];
			$this->almacenadora=$_POST['alma1'];
			$this->producto=$_POST['prod1'];
			$this->cantidad=$_POST['cant1'];
			$this->precio=$_POST['sub1'];
			$sql=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades+$this->cantidad_original WHERE id_almacenadora=$this->almacenadora_original AND id_producto=$this->producto_original LIMIT 1;");
			$sql1=$this->db->query("SELECT subtotal_num, desc_porcentaje FROM cotizacion_juguetes WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
			$data1=$this->db->recorrer($sql1);
			$subtotal=$data1[0]-$this->precio_original;
			$pre=number_format($this->precio, 2, ",", ".");
			$pre=$pre." Bs.";
			$subtotal=$subtotal+$this->precio;
			$sub=number_format($subtotal, 2, ",", ".");
			$sub=$sub." Bs.";
			if($data1[1]!=""){
				$descuento=$subtotal*$data1[1]/100;
				$desc=number_format($descuento, 2, ",", ".");
				$desc=$desc." Bs.";
				$total=$subtotal-$descuento;
				$tot=number_format($total, 2, ",", ".");
				$tot=$tot." Bs.";
				if($this->cantidad>$this->cantidad_original){
					$cantidad=$this->cantidad-$this->cantidad_original;
					$sql2=$this->db->query("UPDATE cotizacion_juguetes SET total='$tot', subtotal='$sub', total_num=$total, descuento='$desc', descuento_num=$descuento, subtotal_num=$subtotal, unidades_total=unidades_total+$cantidad WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$sql3=$this->db->query("UPDATE ordenes_juguetes SET cantidad=$this->cantidad, precio_total='$pre', precio_num=$this->precio, id_producto=$this->producto, id_almacenadora=$this->almacenadora WHERE id_ordenes=$this->id_orden LIMIT 1;");
					$sql4=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				}else if($this->cantidad<$this->cantidad_original){
					$cantidad=$this->cantidad_original-$this->cantidad;
					$sql2=$this->db->query("UPDATE cotizacion_juguetes SET total='$tot', subtotal='$sub', total_num=$total, descuento='$desc', descuento_num=$descuento, subtotal_num=$subtotal, unidades_total=unidades_total-$cantidad WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$sql3=$this->db->query("UPDATE ordenes_juguetes SET cantidad=$this->cantidad, precio_total='$pre', precio_num=$this->precio, id_producto=$this->producto, id_almacenadora=$this->almacenadora WHERE id_ordenes=$this->id_orden LIMIT 1;");
					$sql4=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				}else if($this->cantidad==$this->cantidad_original){
					$sql2=$this->db->query("UPDATE cotizacion_juguetes SET total='$tot', subtotal='$sub', total_num=$total, descuento='$desc', descuento_num=$descuento, subtotal_num=$subtotal WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$sql3=$this->db->query("UPDATE ordenes_juguetes SET cantidad=$this->cantidad, precio_total='$pre', precio_num=$this->precio, id_producto=$this->producto, id_almacenadora=$this->almacenadora WHERE id_ordenes=$this->id_orden LIMIT 1;");
					$sql4=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				}
			}else{
				if($this->cantidad>$this->cantidad_original){
					$cantidad=$this->cantidad-$this->cantidad_original;
					$sql2=$this->db->query("UPDATE cotizacion_juguetes SET total='$sub', subtotal='$sub', total_num=$subtotal, subtotal_num=$subtotal, unidades_total=unidades_total+$cantidad WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$sql3=$this->db->query("UPDATE ordenes_juguetes SET cantidad=$this->cantidad, precio_total='$pre', precio_num=$this->precio, id_producto=$this->producto, id_almacenadora=$this->almacenadora WHERE id_ordenes=$this->id_orden LIMIT 1;");
					$sql4=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				}else if($this->cantidad<$this->cantidad_original){
					$cantidad=$this->cantidad_original-$this->cantidad;
					$sql2=$this->db->query("UPDATE cotizacion_juguetes SET total='$sub', subtotal='$sub', total_num=$subtotal, subtotal_num=$subtotal, unidades_total=unidades_total-$cantidad WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$sql3=$this->db->query("UPDATE ordenes_juguetes SET cantidad=$this->cantidad, precio_total='$pre', precio_num=$this->precio, id_producto=$this->producto, id_almacenadora=$this->almacenadora WHERE id_ordenes=$this->id_orden LIMIT 1;");
					$sql4=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				}else if($this->cantidad==$this->cantidad_original){
					$sql2=$this->db->query("UPDATE cotizacion_juguetes SET total='$sub', subtotal='$sub', total_num=$subtotal, subtotal_num=$subtotal WHERE id_cotizacion=$this->id_cotizacion LIMIT 1;");
					$sql3=$this->db->query("UPDATE ordenes_juguetes SET cantidad=$this->cantidad, precio_total='$pre', precio_num=$this->precio, id_producto=$this->producto, id_almacenadora=$this->almacenadora WHERE id_ordenes=$this->id_orden LIMIT 1;");
					$sql4=$this->db->query("UPDATE existencia_juguetes SET unidades=unidades-$this->cantidad WHERE id_almacenadora=$this->almacenadora AND id_producto=$this->producto LIMIT 1;");
				}
			}
			$this->db->liberar($sql1);
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Edito la orden ".$this->orden." de la cotizacion Juguetes: ".$this->id_cotizacion;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
			header("location: ?view=Juguetes&mode=editCotizacion&id=".$this->id_cotizacion."&success=5");
		}
		public function AddOrden($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->orden=$_POST['orden'];
			$this->usuario=$usuario;
			$sql=$this->db->query("SELECT * FROM despacho_juguetes WHERE despacho='$this->orden';");
			if($this->db->rows($sql)==0){
				for($i=1; $i<5; $i++){
					if(isset($_POST['pago'.$i])){
						if($_POST['pago'.$i]!=""){
							$this->pago=$_POST['pago'.$i];
							if(!empty($_POST['factura'.$i])){
								$this->factura=$_POST['factura'.$i];
							}else{
								$this->factura="";
							}
							if(!empty($_POST['contado'.$i])){
								$this->contado=$_POST['contado'.$i];
							}else{
								$this->contado="";
							}
							$this->db->query("INSERT INTO despacho_juguetes(id_cotizacion, despacho, pago, deposito, banco) VALUES($this->id_cotizacion, '$this->orden', '$this->pago', '$this->factura', '$this->contado');");
							$this->db->query("UPDATE cotizacion_juguetes SET despacho=1 WHERE id_cotizacion=$this->id_cotizacion;");
							$ip=$_SERVER['REMOTE_ADDR'];
							$evento="Inserto el despacho de la cotizacion juguetes: ".$this->id_cotizacion;
							$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'INSERT');");
						}
					}
				}
				header("location: ?view=Juguetes&mode=allCotizacion&success=2");
			}else{
				header("location: ?view=Juguetes&mode=addOrden&id=".$this->id_cotizacion."&error=2");
			}
		}
		public function EditOrden($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->orden=$_POST['orden'];
			$this->contador=$_POST['contador'];
			$this->usuario=$usuario;
			$this->db->query("UPDATE despacho_juguetes SET despacho='$this->orden' WHERE id_cotizacion=$this->id_cotizacion;");
			for($i=1; $i<=$this->contador; $i++){
				if(isset($_POST['pago'.$i])){
					if($_POST['pago'.$i]!=""){
						$this->pago=$_POST['pago'.$i];
						if(!empty($_POST['factura'.$i])){
							$this->factura=$_POST['factura'.$i];
						}else{
							$this->factura="";
						}
						if(!empty($_POST['contado'.$i])){
							$this->contado=$_POST['contado'.$i];
						}else{
							$this->contado="";
						}
						$this->id_despacho=$_POST['id_despacho'.$i];
						$this->db->query("UPDATE despacho_juguetes SET pago='$this->pago', deposito='$this->factura', banco='$this->contado' WHERE id_despacho=$this->id_despacho;");
						$ip=$_SERVER['REMOTE_ADDR'];
						$evento="Edito el despacho de la cotizacion juguetes: ".$this->id_cotizacion;
						$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
					}
				}
			}
			header("location: ?view=Juguetes&mode=editOrden&id=".$this->id_cotizacion."&success=2");
		}
		public function AddPago($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->orden=$_POST['orden'];
			$this->usuario=$usuario;
			$this->pago=$_POST['pago'];
			if(!empty($_POST['factura'])){
				$this->factura=$_POST['factura'];
			}else{
				$this->factura="";
			}
			if(!empty($_POST['contado'])){
				$this->contado=$_POST['contado'];
			}else{
				$this->contado="";
			}
			$this->db->query("INSERT INTO despacho_juguetes(id_cotizacion, despacho, pago, deposito, banco) VALUES($this->id_cotizacion, '$this->orden', '$this->pago', '$this->factura', '$this->contado');");
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Inserto un pago a la cotizacion juguetes: ".$this->id_cotizacion;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'INSERT');");
			header("location: ?view=Juguetes&mode=editOrden&id=".$this->id_cotizacion."&success=2");
		}
		public function DeletePago($usuario){
			$this->id_cotizacion=intval($_GET['id']);
			$this->usuario=$usuario;
			$this->id_despacho=$_GET['id_despacho'];
			$this->db->query("DELETE FROM despacho_juguetes WHERE id_despacho=$this->id_despacho;");
			$indicesServer = array('REMOTE_ADDR',);
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Elimino el pago con id ".$this->id_despacho." de la cotizacion del juguetes: ".$this->id_cotizacion;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'DELETE');");
			header("location: ?view=Juguetes&mode=editOrden&id=".$this->id_cotizacion."&success=3");
		}
		public function __destruct(){
			$this->db->close();
		}
	}
?>