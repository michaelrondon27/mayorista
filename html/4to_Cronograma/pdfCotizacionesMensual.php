<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$fecha=date("d-m-Y");
	$total=0;
	$nevera=0;
	$aire=0;
	$lavadora=0;
	$secadora=0;
	$cocina=0;
	$horno=0;
	$tv=0;
	$freezer=0;
	$ventilador=0;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="reporte pdf de cotizacion 4to por fecha desde ".$_POST['desde']." hasta".$_POST['hasta'];
	$event=$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario' '$evento', NOW(), 'REPORTE');");
	$sql=$db->query("SELECT c.cotizacion, c.fecha, c.total, c.total_num, e.nombre, c.unidades_total, c.id_cotizacion FROM cotizacion_4to c INNER JOIN empresa e ON c.id_empresa=e.id_empresa WHERE c.fecha BETWEEN '$desde' AND '$hasta' AND despacho=1 ORDER BY c.fecha;");
	if($db->rows($sql)>0){
		$encabezado="
			<div class='contenedor'>
				<div class='logo'>
					<img src='views/app/images/baner.png' width='' height=''>
				</div>
				<div align='center'>
					COMERSSO MAYORISTA<br><br><br>
				</div>
				<div align=center>
					Reporte de cotizaciones desde ".$_POST['desde']." hasta ".$_POST['hasta']."
				</div>
				<br>
				<div align='center'>
					Fecha: ".$fecha."
				</div>
				<div class='clear'></div>
				<table>
					<tr>
						<td class='abajo izquierda' align=center >FECHA</td>
						<td class='abajo izquierda' align=center >BENEFICIARIO</td>
						<td class='abajo izquierda' align=center>N° COTIZACIÓN</td>
						<td class='abajo izquierda' align=center>CANTIDAD</td>
						<td class='abajo' align=center>TOTAL</td>
					</tr>";
		$reporte=new mPDF('', 'Letter'); 	
		$reporte->addPage();
		$css=file_get_contents('views/app/css/reporte.css');
		$reporte->writeHTML($css, 1);
		$reporte->writeHTML($encabezado);
		while($data=$db->recorrer($sql)){
			$sql1=$db->query("SELECT id_producto, cantidad FROM ordenes_4to WHERE id_cotizacion=$data[6];");
			while($data1=$db->recorrer($sql1)){
				if($data1[0]==1){
					$nevera=$nevera+$data1[1];
				}else if($data1[0]==2){
					$aire=$aire+$data1[1];
				}else if($data1[0]==3){
					$lavadora=$lavadora+$data1[1];
				}else if($data1[0]==4){
					$secadora=$secadora+$data1[1];
				}else if($data1[0]==5){
					$cocina=$cocina+$data1[1];
				}else if($data1[0]==6){
					$horno=$horno+$data1[1];
				}else if($data1[0]==7){
					$tv=$tv+$data1[1];
				}else if($data1[0]==8){
					$freezer=$freezer+$data1[1];
				}else if($data1[0]==9){
					$ventilador=$ventilador+$data1[1];
				}
			}
			$fec=date("d-m-Y", strtotime($data[1]));
			$productos="
			<tr>
				<td class='abajo izquierda' align='center'>".$fec."</td>
				<td class='abajo izquierda' align='center'>".$data[4]."</td>
				<td class='abajo izquierda' align='center'>".$data[0]."</td>
				<td class='abajo izquierda' align='center'>".$data[5]."</td>
				<td class='abajo' align='right'>".$data[2]."</td>
			</tr>";
			$reporte->writeHTML($productos);
			$cant=$cant+$data[5];
			$total=$total+$data[3];
		}
		$total=number_format($total, 2, ".", ",");
		$total=$total." Bs.";
		$footer="
				<tr>
					<td colspan='3' align='right' class='izquierda abajo'>
						<strong>CANTIDAD TOTAL:</strong>
					</td>
					<td align='center' class='izquierda abajo'>".$cant."</td>
					<td align='center' class='abajo'></td>
				</tr>
				<tr>
					<td colspan='4' align='right' class='izquierda'>
						<strong>TOTAL:</strong>
					</td>
					<td align='right'>".$total."</td>
				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td class='abajo' colspan='3'>Cantidad de productos vendidos por categoría</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>Nevera: ".$nevera."</td>
					<td class='abajo izquierda'>Aire Acondicionado: ".$aire."</td>
					<td class='abajo'>Lavadora: ".$lavadora."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>Secadora: ".$secadora."</td>
					<td class='abajo izquierda'>Cocina Independiente: ".$cocina."</td>
					<td class='abajo'>Horno: ".$horno."</td>
				</tr>
				<tr>
					<td class=' izquierda'>Televisor: ".$tv."</td>
					<td class='izquierda'>Freezer: ".$freezer."</td>
					<td>Ventilador: ".$ventilador."</td>
				</tr>
			</table>
	";
	$reporte->writeHTML($footer);
	$reporte->setFooter('{PAGENO}');
	$reporte->SetTitle('Reporte Financiero desde '.$_POST['desde'].' hasta '.$_POST['hasta']);
	$reporte->Output('Reporte Financiero desde'.$_POST['desde'].' hasta '.$_POST['hasta'].'.pdf', 'I');
	$reporte->Output();
	}else{
		header("location: ?view=4toCronograma&mode=estadoCotizaciones&error=2");
	}
?>