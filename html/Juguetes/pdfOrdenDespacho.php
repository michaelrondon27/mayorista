<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$id_cotizacion=$_GET['id'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Reporte de la orden de despacho de la cotizacion de juguetes en pdf: ".$id_cotizacion;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'REPORTE');");
	$sql=$db->query("SELECT c.cotizacion, c.total, c.fecha, e.nombre, e.rif, e.direccion, e.telefono, e.contacto, ct.cod_tlf, c.descuento, c.desc_porcentaje, d.despacho, e.telefono2, e.correo, d.banco, d.deposito FROM cotizacion_juguetes c INNER JOIN empresa e ON c.id_empresa=e.id_empresa INNER JOIN cod_tlf ct ON e.id_cod_tlf=ct.id_cod_tlf INNER JOIN despacho_juguetes d ON c.id_cotizacion=d.id_cotizacion WHERE c.id_cotizacion=$id_cotizacion LIMIT 1;");
	if($db->rows($sql)>0){
		$data=$db->recorrer($sql);
		if($data[12]!=""){
			$sql2=$db->query("SELECT ct.cod_tlf FROM empresa e INNER JOIN cod_tlf ct ON e.id_cod_tlf2=ct.id_cod_tlf WHERE nombre='$data[3]' LIMIT 1;");
			$data2=$db->recorrer($sql2);
			$otro_tlf=$data2[0]."-".$data[12];
		}else{
			$otro_tlf="";
		}
		$tlf=$data[8]."-".$data[6];
		$fec=$hasta=date("d-m-Y", strtotime($data[1]));
		$encabezado="
			<div class='contenedor'>
				<div class='logo'>
					<img src='views/app/images/baner.png' width='' height=''>
				</div>
				<div align=center>
				<strong>ORDEN DE DESPACHO</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;COMERSSO MAYORISTA<br><br>
				</div>
				<table class='header'>
					<tr>
						<td class='abajo izquierda'>Cotizaci&oacute;n: ".$data[0]."</td>
						<td class='abajo izquierda'>Orden de despacho: ".$data[11]."</td>
						<td class='abajo'>RIF:".$data[4]."</td>
					</tr>
					<tr>
						<td class='abajo izquierda'>BENEFICIARIO: ".$data[3]."</td>
						<td colspan='2' class='abajo '>DIRECCION: ".$data[5]."</td>
					</tr>
					<tr>
						<td class='abajo izquierda'>TELÉFONO: ".$tlf."</td>
						<td colspan='2' class='abajo'>PERSONA DE CONTACTO: ".$data[7]."</td>
					</tr>
					<tr>
						<td class='izquierda'>OTRO TELÉFONO: ".$otro_tlf."</td>
						<td colspan='2'>CORREO: ".$data[13]."</td>
					</tr>
				</table>
				<table>
					<tr>
						<td class='abajo izquierda' colspan='3'>BANCO: ".$data[14]."</td>
						<td class='abajo' colspan='3'>DEPOSITO O TRANSFERENCIA: ".$data[15]."</td>
					</tr>
					<tr>
						<td class='abajo izquierda' align=center >ITEM</td>
						<td class='abajo izquierda' align=center>CANTIDAD</td>
						<td class='abajo izquierda' align=center>PRODUCTO</td>
						<td class='abajo izquierda' align=center>ALMACENADORA</td>
						<td class='abajo izquierda' align=center>ENTREGADO POR:</td>
						<td class='abajo' align=center>RECIBIDO POR:</td>
					</tr>";
		$reporte=new mPDF('', 'Letter'); 	
		$reporte->addPage();
		$css=file_get_contents('views/app/css/reporte.css');
		$reporte->writeHTML($css, 1);
		$reporte->writeHTML($encabezado);
		$sql1=$db->query("SELECT o.cantidad, p.producto, a.nombre FROM ordenes_juguetes o INNER JOIN productos_juguetes p ON o.id_producto=p.id_producto INNER JOIN almacenadoras_juguetes a ON o.id_almacenadora=a.id_almacenadora WHERE id_cotizacion=$id_cotizacion;");
		if($db->rows($sql1)>0){
			$contador=1;
			while($data1=$db->recorrer($sql1)){
				$productos="
					<tr>
						<td class='abajo izquierda' align=center>".$contador."</td>
						<td class='abajo izquierda' align=center>".$data1[0]."</td>
						<td class='abajo izquierda' align=center>".$data1[1]."</td>
						<td class='abajo izquierda' align=center>".$data1[2]."</td>
						<td class='abajo izquierda' align=center></td>
						<td class='abajo' align=right></td>
					</tr>";
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
		$footer="
			</table>
			<table>
				<tr><td colspan='2' class='abajo'><strong>NOTA: Válido por 10 días hábiles a partir de la fecha de emisión Únicamente con la nota de entrega original se podrá realizar el retiro de los productos y copia de cédula de identidad. </strong></td>
				</tr>
				<tr><td colspan='2' class='abajo'><strong>Importante: Para la confirmación de está orden las Almacenadoras pueden contactar a COMERSSO, S.A. por los siguiente números telefónicos: 0212-509-67-57/6838/6789 </strong></td>
				</tr>
				<tr>
					<td class='izquierda'><strong>Coordinador del Despacho:</strong></td>
					<td><strong>Presidente: </strong></td>
				</tr>
				<tr>
					<td class=' izquierda'> <strong>My. Argenis Hernández Solórzano</strong></td>
					<td><strong>Tcnel. Antonio José Pérez Suárez</strong></td>
				<tr>
					<td class='abajo izquierda'>FIRMA:</td>
					<td class='abajo '>FIRMA:</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>FECHA COTIZACÓN: ".$fec."</td>
					<td class='abajo ' align=right >FECHA: ".$fecha."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'><strong>ORIGINAL</strong></td>
					<td class='abajo' align=right ><strong>N°:".$data[11]."</strong></td>
				</tr>
				<tr><td colspan='2' class='abajo'>Almacenadora Caracas :Calle Principal de los Flores de Catia, Callejón Segnini, Los Flores, Caracas, D.C Tef: (0212) 862.6047</td>
				</tr>
				<tr><td colspan='2' class='abajo'>Almacenadora Pto Cabello: Terrenos Cumboto. Av. Salom. Frente Comando Policial Pto Cabello, Edo. Carabobo Telf: (0242) 364.54.26</td>
				</tr>
				<tr><td colspan='2' class='abajo'>Almacenadora Carabobo: Zona Industrial Sur, Av. Dr. Domingo Olavarría; Valencia, Edo. Carabobo Telf: (0241) 838.44.68</td>
				</tr>
				<tr><td colspan='2' class='abajo'>Almacenadora Centro: Av. Antón Philips. Zona Industrial San Vicente; Maracay, Edo. Aragua Telf: (0243) 553.70.04</td>
				</tr>
				<tr><td colspan='2' class='abajo'><strong>CORPORACIÓN DE COMERCIO Y SUMINISTRO SOCIALISTA, (COMERSSO), S.A. TELEFONOS:0212-5096757/6838/6789</strong></td>
				</tr>
				<tr>
					<td class='izquierda'><strong>RECIBIDO POR:</strong></td>
					<td><strong>ENTREGADO POR:</strong></td>
				</tr>

			</table>		
		</div>
	";
	$reporte->writeHTML($footer);
	$reporte->Output();
}
?>