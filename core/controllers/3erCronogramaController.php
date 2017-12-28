<?php
	if(isset($_SESSION['app_id'])){
		$isset_id=isset($_GET['id']) AND is_numeric($_GET['id']) AND $_GET['id']>=1;
		require('core/models/class3erCronograma.php');
		$cronograma=new Cronograma3er();
		switch (isset($_GET['mode']) ? $_GET['mode'] : null){
			case 'addCotizacion':
				if($_POST){
					$db=new Conexion();
					if(!empty($_POST['cotizacion']) && !empty($_POST['fecha']) && !empty($_POST['empresa']) && !empty($_POST['total'])){
						$cotizacion=$_POST['cotizacion'];
						$empresa=$_POST['empresa'];
						$total=$_POST['total'];
						$productos=$_POST['productos'];
						$descuento=$_POST['descuento'];
						$subtotal=0;
						$uni_total=0;
						$fecha=date("Y-m-d", strtotime($_POST['fecha']));
						$sql=$db->query("SELECT * FROM cotizacion WHERE cotizacion='$cotizacion';");
						if($db->rows($sql)==0){
							$sql1=$db->query("INSERT INTO cotizacion(cotizacion, id_empresa, total, fecha, registro) VALUES('$cotizacion', $empresa, '$total', '$fecha', NOW());");
							$indicesServer = array('REMOTE_ADDR',);
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$ip=$_SERVER['REMOTE_ADDR'];
							$evento="Inserto la cotizacion del 3er cornograma: ".$cotizacion.", con fecha: ".$fecha." y el id del beneficiario: ".$empresa;
							$sql6=$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'INSERT');");
							$sql2=$db->query("SELECT id_cotizacion FROM cotizacion WHERE cotizacion='$cotizacion';");
							$data=$db->recorrer($sql2);
							for($x=1;$x<=$productos;$x++){
								if(isset($_POST['cant'.$x])){
									$alma=$_POST['alma'.$x];
									$prod=$_POST['prod'.$x];
									$cant=$_POST['cant'.$x];
									$mod=$_POST['mod'.$x];
									$sql5=$db->query("SELECT precio FROM modelo WHERE id_modelo=$mod LIMIT 1;");
									$data5=$db->recorrer($sql5);
									$precio=$cant*$data5[0];
									$pre=number_format($precio, 2, ',', '.')." Bs.";
									$pre_num=$precio;
									$subtotal=$subtotal+$precio;
									$uni_total=$uni_total+$cant;
									if($cant>0){
										$sql3=$db->query("INSERT INTO ordenes(id_cotizacion, id_modelo, cantidad, precio_total, precio_num, id_almacenadora, id_producto) VALUES($data[0], $mod, $cant, '$pre', $pre_num, $alma, $prod);");
										$sql4=$db->query("UPDATE existencia SET unidades=unidades-$cant WHERE id_modelo=$mod AND id_almacenadora=$alma;");
										$indicesServer = array('REMOTE_ADDR',);
										$ip=$_SERVER['REMOTE_ADDR'];
										$evento="Inserto el modelo: ".$mod.", de la almacenadora: ".$alma." y la cantidad de ".$cant." unidades a la cotizacion".$data[0];
										$sql6=$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'INSERT');");
									}
								}
							}
							if($descuento!="" || $descuento>0){
								$sub_num=$subtotal;
								$subtotal=number_format($subtotal, 2, ',', '.')." Bs.";
								$desc_num=$sub_num*($descuento/100);
								$desc=number_format($desc_num, 2, ',', '.')." Bs.";
								$total_num=$sub_num-$desc_num;
								$total=number_format($total_num, 2, ',', '.')." Bs.";
								$sql7=$db->query("UPDATE cotizacion SET total='$total', subtotal='$subtotal', total_num=$total_num, subtotal_num=$sub_num, descuento='$desc', descuento_num=$desc_num, desc_porcentaje=$descuento, unidades_total=$uni_total WHERE id_cotizacion=$data[0] LIMIT 1;");
							}else{
								$sub_num=$subtotal;
								$subtotal=number_format($subtotal, 2, ',', '.')." Bs.";
								$total_num=$sub_num;
								$total=$subtotal;
								$sql7=$db->query("UPDATE cotizacion SET total='$total', subtotal='$subtotal', total_num=$total_num, subtotal_num=$sub_num, unidades_total=$uni_total WHERE id_cotizacion=$data[0] LIMIT 1;");
							}
							$db->liberar($sql2);
							$db->liberar($sql5);
							header("location: ?view=3erCronograma&mode=addCotizacion&success=true");
						}else{
							header("location: ?view=3erCronograma&mode=addCotizacion&error=2");
						}
					}else{
						header("location: ?view=3erCronograma&mode=addCotizacion&error=1");
					}
				}else{
					include(HTML_DIR.'3er_Cronograma/addCotizacion.php');
				}
				break;
			case 'addProducto':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['alma1']) && !empty($_POST['prod1']) && !empty($_POST['cant1']) && !empty($_POST['mod1'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$cronograma->AddProducto($usuario);
						}else{
							header("location: ?view=3erCronograma&mode=addProducto&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/addProducto.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'addDescuento':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						$usuario=$_users[$_SESSION['app_id']]['user'];
						$cronograma->AddDescuento($usuario);
					}else{
						include(HTML_DIR.'3er_Cronograma/addDescuento.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'editCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['cotizacion']) && !empty($_POST['fecha']) && !empty($_POST['empresa'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$cronograma->EditCotizacion($usuario);
						}else{
							header("location: ?view=3erCronograma&mode=editCotizacion&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/editCotizacion.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'editProducto':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['alma1']) && !empty($_POST['prod1']) && !empty($_POST['cant1']) && !empty($_POST['mod1'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$cronograma->EditProducto($usuario);
						}else{
							header("location: ?view=3erCronograma&mode=editCotizacion&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/editProducto.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'deleteCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					$usuario=$_users[$_SESSION['app_id']]['user'];
					$cronograma->DeleteCotizacion($usuario);
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'deleteProducto':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					$usuario=$_users[$_SESSION['app_id']]['user'];
					$cronograma->DeleteProducto($usuario);
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'verCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					include(HTML_DIR.'3er_Cronograma/verCotizacion.php');
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'pdfCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					include(HTML_DIR.'3er_Cronograma/pdfCotizacion.php');
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'pdfFactura':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['fecha'])){
							include(HTML_DIR.'3er_Cronograma/pdfFactura.php');
						}else{
							header("location: ?view=3erCronograma&mode=factura&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/factura.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'excelCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					include(HTML_DIR.'3er_Cronograma/excelCotizacion.php');
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'addOrden':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['orden']) && !empty($_POST['pago1'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$cronograma->AddOrden($usuario);
						}else{
							header("location: ?view=3erCronograma&mode=addOrden&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/addOrden.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'editOrden':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['orden'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$cronograma->EditOrden($usuario);
						}else{
							header("location: ?view=3erCronograma&mode=editOrden&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/editOrden.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'addPago':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					if($_POST){
						if(!empty($_POST['pago'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$cronograma->AddPago($usuario);
						}else{
							header("location: ?view=3erCronograma&mode=editOrden&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'3er_Cronograma/editOrden.php');
					}
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'deletePago':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					$usuario=$_users[$_SESSION['app_id']]['user'];
					$cronograma->DeletePago($usuario);
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'estadoFinanciero':
				if($_POST){
					if(!empty($_POST['desde']) && !empty($_POST['hasta'])){
						include(HTML_DIR.'3er_Cronograma/pdfFinanciero.php');
					}else{
						header('location: ?view=3erCronograma&mode=estadoFinanciero&error=1');
					}					
				}else{
					include(HTML_DIR.'3er_Cronograma/estadoFinanciero.php');
				}
				break;
			case 'estadoCotizaciones':
				if($_POST){
					if(!empty($_POST['desde']) && !empty($_POST['hasta'])){
						if($_GET['tipo']=='pdf'){
							include(HTML_DIR.'3er_Cronograma/pdfCotizacionesMensual.php');
						}else if($_GET['tipo']=='excel'){
							include(HTML_DIR.'3er_Cronograma/excelCotizacionesMensual.php');
						}
					}else{
						header('location: ?view=3erCronograma&mode=estadoCotizaciones&error=1');
					}					
				}else{
					include(HTML_DIR.'3er_Cronograma/estadoCotizaciones.php');
				}
				break;
			case 'factura':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					include(HTML_DIR.'3er_Cronograma/factura.php');
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'pdfOrdenDespacho':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					include(HTML_DIR.'3er_Cronograma/pdfOrdenDespacho.php');
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'anularCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					$usuario=$_users[$_SESSION['app_id']]['user'];
					$cronograma->AnularCotizacion($usuario);
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'reversarCotizacion':
				if($isset_id AND array_key_exists($_GET['id'], $_cotizacion3er)){
					$usuario=$_users[$_SESSION['app_id']]['user'];
					$cronograma->ReversarCotizacion($usuario);
				}else{
					header('location: ?view=3erCronograma');
				}
				break;
			case 'pdfDetallado':
				if($_POST){
					if(!empty($_POST['desde']) && !empty($_POST['hasta']) && !empty($_POST['tipo'])){
						if($_POST['tipo']=='PDF'){
							include(HTML_DIR.'3er_Cronograma/pdfDetallado.php');
						}else if($_POST['tipo']=='EXCEL'){
							include(HTML_DIR.'3er_Cronograma/excelDetallado.php');
						}else{
							include(HTML_DIR.'3er_Cronograma/detallado.php');
						}
					}else{
						header('location: ?view=3erCronograma&mode=pdfDetallado&error=1');
					}					
				}else{
					include(HTML_DIR.'3er_Cronograma/detallado.php');
				}
				break;
			default:
				include(HTML_DIR.'3er_Cronograma/allCotizacion.php');
				break;
		}
	}else{
		header('location: ?view=index');
	}
?>