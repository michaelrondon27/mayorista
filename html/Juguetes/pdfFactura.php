<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$id_cotizacion=$_GET['id'];
	$fecha=$_POST['fecha'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Factura de la cotizacion de Juguetes: ".$id_cotizacion;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'REPORTE');");
	$encabezado="
		<div class='contenedor'>
			<div style='margin-top: 200px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
			<table>
				<tr style='background-color: #f00;'>
					<td colspan='2' class='abajo' align='center'>CLIENTE</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
					<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
				</tr>
				<tr>
					<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
				</tr>
				<tr>
					<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
					<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
				</tr>
			</table>
			<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
			<table>
				<tr style='background-color: #f00;'>
					<td class='abajo izquierda' align=center >ITEM</td>
					<td class='abajo izquierda' align=center>PRODUCTO</td>
					<td class='abajo izquierda' align=center>CANTIDAD</td>
					<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
					<td class='abajo' align=center>SUBTOTAL</td>
				</tr>";
	$reporte=new mPDF('', 'Letter'); 	
	$reporte->addPage();
	$css=file_get_contents('views/app/css/reporte.css');
	$reporte->writeHTML($css, 1);
	$reporte->writeHTML($encabezado);
	$sql=$db->query("SELECT o.cantidad, p.producto, p.precio, o.precio_total, o.precio_num FROM ordenes_juguetes o INNER JOIN productos_juguetes p ON o.id_producto=p.id_producto WHERE id_cotizacion=$id_cotizacion;");
	if($num=$db->rows($sql)>0){
		$contador=1;
		$total=0;
		while($data=$db->recorrer($sql)){
			$pre_uni=number_format($data[2], 2, ',', '.')." Bs.";
			if($contador<=15){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>15 && $contador<=16){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>16 && $contador<=30){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>30 && $contador<=31){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>31 && $contador<=45){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>45 && $contador<=46){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>46 && $contador<=60){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>60 && $contador<=61){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>61 && $contador<=75){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>75 && $contador<=76){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>76 && $contador<=90){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>90 && $contador<=91){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>91 && $contador<=105){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}else if($contador>105 && $contador<=106){
				$sub=$total;
				if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
					$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
					$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
					$tot=$sub-$desc;
					$desc=number_format($desc, 2, ',', '.')." Bs.";
					$tot=number_format($tot, 2, ',', '.')." Bs.";
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>DESCUENTO: ".$porcentaje."</strong>
								</td>
								<td align='right' class='abajo'>".$desc."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$tot."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}else{
					$sub=number_format($sub, 2, ',', '.')." Bs.";
					$total=0;
					$productos="
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>Base Imponible: </strong>
								</td>
								<td align='right' class='abajo'>".$sub."</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda abajo'>
									<strong>IVA 12%: </strong>
								</td>
								<td align='right' class='abajo'>0,00</td>
							</tr>
							<tr>
								<td colspan='4' align='right' class='izquierda'>
									<strong>TOTAL:</strong>
								</td>
								<td align='right'>".$sub."</td>
							</tr>
						</table>
						<div style='margin-top: 200px; text-align: right; font-size: 14px;'><strong></strong></div>
						<br>
						<div style='margin-top: 140px; text-align: left; font-size: 14px;'><strong>Fecha: ".$fecha."</strong></div>
						<table>
							<tr style='background-color: #f00;'>
								<td colspan='2' class='abajo' align='center'>CLIENTE</td>
							</tr>
							<tr>
								<td class='abajo izquierda'>Rif:".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['rif']."</td>
								<td class='abajo'>Razón Social: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['nombre']."</td>
							</tr>
							<tr>
								<td colspan='2' class='abajo '>Dirección: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['direccion']."</td>
							</tr>
							<tr>
								<td class='izquierda'>TELÉFONO: ".$_cod_tlf[$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['telefono']."</td>
								<td>Correo: ".$_beneficiario[$_cotizacionJuguetes[$id_cotizacion]['id_empresa']]['correo']."</td>
							</tr>
						</table>
						<div style='margin-top: 20px; text-align: center; font-size: 14px;'><strong>Productos: Detalles de Compras</strong></div>
						<table style='text-align: center; font-size: 14px;'>
							<tr style='background-color: #f00;'>
								<td class='abajo izquierda' align=center >ITEM</td>
								<td class='abajo izquierda' align=center>PRODUCTO</td>
								<td class='abajo izquierda' align=center>CANTIDAD</td>
								<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
								<td class='abajo' align=center>SUBTOTAL</td>
							</tr>
							<tr>
								<td class='abajo izquierda' align='center'>".$contador."</td>
								<td class='abajo izquierda' align='center'>".$data[1]."</td>
								<td class='abajo izquierda' align='center'>".$data[0]."</td>
								<td class='abajo izquierda' align='right'>".$pre_uni."</td>
								<td class='abajo' align='right'>".$data[3]."</td>
							</tr>
					";
					$total=$total+$data[4];
				}
			}else if($contador>106 && $contador<=120){
				$productos="
					<tr>
						<td class='abajo izquierda' align='center'>".$contador."</td>
						<td class='abajo izquierda' align='center'>".$data[1]."</td>
						<td class='abajo izquierda' align='center'>".$data[0]."</td>
						<td class='abajo izquierda' align='right'>".$pre_uni."</td>
						<td class='abajo' align='right'>".$data[3]."</td>
					</tr>
				";
				$total=$total+$data[4];
			}
			$contador++;
			$reporte->writeHTML($productos);
		}
	}
	$sub=$total;
	if($_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']!=""){
		$porcentaje=$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']."%";
		$desc=$sub*$_cotizacionJuguetes[$id_cotizacion]['desc_porcentaje']/100;
		$tot=$sub-$desc;
		$desc=number_format($desc, 2, ',', '.')." Bs.";
		$tot=number_format($tot, 2, ',', '.')." Bs.";
		$sub=number_format($sub, 2, ',', '.')." Bs.";
		$total=0;
		$footer="
				<tr>
					<td colspan='4' align='right' class='izquierda abajo'>
						<strong>Base Imponible: </strong>
					</td>
					<td align='right' class='abajo'>".$sub."</td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='izquierda abajo'>
						<strong>DESCUENTO: ".$porcentaje."</strong>
					</td>
					<td align='right' class='abajo'>".$desc."</td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='izquierda abajo'>
						<strong>IVA 12%: </strong>
					</td>
					<td align='right' class='abajo'>0,00</td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='izquierda'>
						<strong>TOTAL:</strong>
					</td>
					<td align='right'>".$tot."</td>
				</tr>
			</table>
		";
	}else{
		$sub=number_format($sub, 2, ',', '.')." Bs.";
		$total=0;
		$footer="
				<tr>
					<td colspan='4' align='right' class='izquierda abajo'>
						<strong>Base Imponible: </strong>
					</td>
					<td align='right' class='abajo'>".$sub."</td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='izquierda abajo'>
						<strong>IVA 12%: </strong>
					</td>
					<td align='right' class='abajo'>0,00</td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='izquierda'>
						<strong>TOTAL:</strong>
					</td>
					<td align='right'>".$sub."</td>
				</tr>
			</table>
		";
	}
	$reporte->writeHTML($footer);
	$reporte->Output();
?>