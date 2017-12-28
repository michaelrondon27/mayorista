<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$id_cotizacion=$_GET['id'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Reporte de la cotizacion del 3er cornograma en pdf: ".$id_cotizacion;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'REPORTE');");
	$tlf=$_cod_tlf[$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['id_cod_tlf']]['cod_tlf']."-".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['telefono'];
	if($_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['id_cod_tlf2']>0){
		$otrotlf=$_cod_tlf[$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['id_cod_tlf2']]['cod_tlf']."-".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['telefono2'];
	}else{
		$otrotlf="";
	}
	$fecha=date("Y", strtotime($_cotizacion3er[$id_cotizacion]['fecha']));
	if($fecha>=2017){
		$persona="My. Ruben Coronado";
	}else{
		$persona="Lcda. Ameleyris Lopez";
	}
	$encabezado="
		<div class='contenedor'>
			<div class='logo'>
				<img src='views/app/images/baner.png' width='100%' height='40'>
			</div>
			<div align='center' style='font-size: 18px;'>
				<strong>COTIZACI&Oacute;N</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMERSSO MAYORISTA<br>
			</div>
			<div>
				Cotizaci&oacute;n: ".$_cotizacion3er[$id_cotizacion]['cotizacion']."
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Fecha: ".$fec=date("d-m-Y", strtotime($_cotizacion3er[$id_cotizacion]['fecha']))."
			</div>
			<div class='clear'></div>
			<table class='header'>
				<tr>
					<td colspan='2' class='abajo'>BENEFICIARIO: ".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['nombre']."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>RIF: ".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['rif']."</td>
					<td class='abajo '>DIRECCION: ".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['direccion']."</td>
				</tr>
				<tr>
					<td class='izquierda abajo'>TELÉFONO: ".$tlf."</td>
					<td class='abajo'>PERSONA DE CONTACTO: ".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['contacto']."</td>
				</tr>
				<tr>
					<td class='izquierda'>OTRO TELÉFONO: ".$otrotlf."</td>
					<td>CORREO: ".$_beneficiario[$_cotizacion3er[$id_cotizacion]['id_empresa']]['correo']."</td>
				</tr>
			</table>
			<table>
				<tr>
					<td class='abajo izquierda' align=center >ITEM</td>
					<td class='abajo izquierda' align=center>ALMACENADORA</td>
					<td class='abajo izquierda' align=center>PRODUCTO</td>
					<td class='abajo izquierda' align=center>CANTIDAD</td>
					<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
					<td class='abajo' align=center>PRECIO TOTAL</td>
				</tr>";
		$reporte=new mPDF('', 'Letter'); 	
		$reporte->addPage();
		$css=file_get_contents('views/app/css/reporte.css');
		$reporte->writeHTML($css, 1);
		$reporte->writeHTML($encabezado);
		$sql=$db->query("SELECT o.cantidad, p.producto, m.modelo, m.precio, o.precio_total, a.nombre FROM ordenes o INNER JOIN productos p ON o.id_producto=p.id_producto INNER JOIN modelo m ON o.id_modelo=m.id_modelo INNER JOIN almacenadoras a ON o.id_almacenadora=a.id_almacenadora WHERE id_cotizacion=$id_cotizacion;");
		if($db->rows($sql)>0){
			$contador=1;
			while($data=$db->recorrer($sql)){
				$pre_uni=number_format($data[3], 2, ',', '.')." Bs.";
				if($variable<=25){
					$productos="
						<tr>
							<td class='abajo izquierda' align=center>".$contador."</td>
							<td class='abajo izquierda' align=center>".$data[5]."</td>
							<td class='abajo izquierda' align=center>".$data[1]." ".$data[2]."</td>
							<td class='abajo izquierda' align=center>".$data[0]."</td>
							<td class='abajo izquierda' align=center>".$pre_uni."</td>
							<td class='abajo' align=right>".$data[4]."</td>
						</tr>
					";
					$variable++;
				}else if($variable>25 && $variable<=26){
					$reporte->AcceptPageBreak();
					$productos="
						</table>
						<br><br><br><br><br><br><br><br><br>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
						<div>
							Cotizaci&oacute;n: ".$_cotizacion3er[$id_cotizacion]['cotizacion']."
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Fecha: ".$fec=date("d-m-Y", strtotime($_cotizacion3er[$id_cotizacion]['fecha']))."
						</div>
						<table>
						<tr>
							<td class='abajo izquierda' align=center >ITEM</td>
							<td class='abajo izquierda' align=center>CANTIDAD</td>
							<td class='abajo izquierda' align=center>PRODUCTO</td>
							<td class='abajo izquierda' align=center>ALMACENADORA</td>
							<td class='abajo izquierda' align=center>PRECIO POR UNIDAD</td>
							<td class='abajo' align=center>PRECIO TOTAL</td>
						</tr>
						<tr>
							<td class='abajo izquierda' align=center>".$contador."</td>
							<td class='abajo izquierda' align=center>".$data[5]."</td>
							<td class='abajo izquierda' align=center>".$data[1]." ".$data[2]."</td>
							<td class='abajo izquierda' align=center>".$data[0]."</td>
							<td class='abajo izquierda' align=center>".$pre_uni."</td>
							<td class='abajo' align=right>".$data[4]."</td>
						</tr>
					";
					$variable++;
				}else if($variable>26 && $variable<=50){
					$productos="
						<tr>
							<td class='abajo izquierda' align=center>".$contador."</td>
							<td class='abajo izquierda' align=center>".$data[5]."</td>
							<td class='abajo izquierda' align=center>".$data[1]." ".$data[2]."</td>
							<td class='abajo izquierda' align=center>".$data[0]."</td>
							<td class='abajo izquierda' align=center>".$pre_uni."</td>
							<td class='abajo' align=right>".$data[4]."</td>
						</tr>
					";
					$variable++;
				}
				$contador++;
				$reporte->writeHTML($productos);
			}
		}else{
			$productos="
				<tr>
					<td class='abajo' colspan='6' align=center >no hay productos en esta cotización.</td>
				</tr>";
			$reporte->writeHTML($productos);
		}
		if($_cotizacion3er[$id_cotizacion]['desc_porcentaje']!=""){
			$descuento="
				<tr>
					<td colspan='3' align='right' class='abajo izquierda'>
						<strong>CANTIDAD TOTAL:</strong>
					</td>
					<td class='abajo izquierda' align=center>".$_cotizacion3er[$id_cotizacion]['unidades_total']."</td>
					<td align='right' class='abajo izquierda'>
						<strong>SUBTOTAL:</strong>
					</td>
					<td class='abajo izquierda' align=center>".$_cotizacion3er[$id_cotizacion]['subtotal']."</td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='abajo izquierda'>
						<strong>DESCUENTO:</strong>
					</td>
					<td class='abajo izquierda' align=center>".$_cotizacion3er[$id_cotizacion]['desc_porcentaje']."%</td>
					<td class='abajo' align=center>".$$cotizacion3er[$id_cotizacion]['descuento']."</td>
				</tr>";
			$reporte->writeHTML($descuento);
		}else{
			$cantidades="
				<tr>
					<td colspan='3' align='right' class='abajo izquierda'>
						<strong>CANTIDAD TOTAL:</strong>
					</td>
					<td class='abajo izquierda' align=center>".$_cotizacion3er[$id_cotizacion]['unidades_total']."</td>
					<td colspan='2' class='abajo'></td>
				</tr>
			";
			$reporte->writeHTML($cantidades);
		}
		$footer="
				<tr>
					<td colspan='5' align='right' class='izquierda'>
						<strong>TOTAL:</strong>
					</td>
					<td align=right>".$_cotizacion3er[$id_cotizacion]['total']."</td>
				</tr>
			</table>
			
			<div class='parrafo' align='center' style='font-size: 9px;'>
				Emitir Cheque a nombre de: CORPORACI&Oacute;N DE COMERCIO Y SUMINISTRO SOCIALISTA, S.A. (COMERSSO), RIF: G-20009301-3 Al n&uacute;mero de Cta: Banco Bicentenario
			</div>
			<div align='center' style='font-size: 9px;'> 
				N° de cuenta 0175-0068-69-0071177539</strong>
			</div>
			<div  align='center' style='font-size: 9px;'>
				Aceptado el presupuesto favor remitir ORDEN DE COMPRA.
			</div>
			<div  align='center' style='font-size: 9px;'>
				Cotizaci&oacute;n v&aacute;lida por 15 d&iacute;as continuos a partir de su recepci&oacute;n.
			</div>
			<div  style='font-size: 9px;'>
				<strong>Consideraciones para la venta:</strong>
			</div>
			<div  style='font-size: 9px;'>
				* El pago debe ser generado por el monto de la cotización. En caso contrario será considerado causal de anulación y se procederá al reintego del monto
			</div>
			<div  style='font-size: 9px;'>
				* Los pagos deben ser reportados a la direccion de correo <strong>pagoscomerssomay@gmail.com</strong>
			</div>
			<div  style='font-size: 9px;'>
				* Para la comercializacion de estos productos el beneficiario debera ser previamente chequeado ante la pagina del programa Mi Casa Bien Equipada:
			</div>
			<div  style='font-size: 9px;'>
				<strong>casaequipada.mincomercio.gob.ve/.reportes_mcbe</strong>
			</div>
			<div  style='font-size: 9px;'>
				Usuario: adelgado
			</div>
			<div  style='font-size: 9px;'>
				Clave: comersso 2016
			</div>
			<div  style='font-size: 9px;'>
				* Queda prohibida la venta de los productos que ya hayan sido adquiridos por los beneficiarios.
			</div>
			<div  style='font-size: 9px;'>
				* Una vez concretada la venta debe remitir el fisico y digital (formato Exel) a COMERSSO, la lista de productos adquiridos por beneficiario a los fines de realizar su registro en la data del programa Mi Casa Bien Equipada.
			</div>
			<div   align='center' style='font-size: 9px;'>
				* La distribucion de estos articulos debe realizarse garantizando la entrega digna a nuestro pueblo, por esta razon <strong>no se permiten por ningun motiva las ventas masivas que generen la exposicion de los beneficiarios a las inclemencias del sol, ni a colas infernales para la recepcion de los equipos</strong>
			</div>
			<div  align='center' style='font-size: 9px;' >
				LOS PRODUCTOS DEBEN SER COMERCIALIZADOS AL PRECIO POR UNIDAD ESTABLECIDOS EN LA PRESENTE COTIZACION
			</div>
			<div class='parrafo' style='font-size: 9px;'>
				Elaborado Por:
			</div>
			<div class='parrafo' style='font-size: 10px;'>
				<div class='subparrafo'>
					<strong>__________________________</strong>
				</div>
				<div class='subparrafo' style='font-size: 10px;'>
					<strong>__________________________</strong>
				</div>
			</div>
			<br><br>
			<div class='titulo' style='font-size: 10px;'>
				<strong>Tcnel. Antonio Jos&eacute; Perez Suarez</strong>
				<br>
				<strong>Presidente (E) COMERSSO</strong>
				<br><br>
				<strong>Av. Lecuna, Torre OESTE de Parque Central, Piso 14, Caracas - Venezuela</strong>
			</div>
		</div>
	";
	$reporte->writeHTML($footer);
	$reporte->Output();

?>