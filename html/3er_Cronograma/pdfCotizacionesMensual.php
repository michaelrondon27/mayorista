<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$fecha=date("d-m-Y");
	$total=0;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="reporte pdf de cotizacion por fecha desde ".$_POST['desde']." hasta".$_POST['hasta'];
	$event=$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario' '$evento', NOW(), 'REPORTE');");
	$sql=$db->query("SELECT c.cotizacion, c.fecha, c.total, c.total_num, e.nombre, c.unidades_total, c.id_cotizacion FROM cotizacion c INNER JOIN empresa e ON c.id_empresa=e.id_empresa WHERE c.fecha BETWEEN '$desde' AND '$hasta' AND despacho=1 ORDER BY c.fecha;");
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
		";

	$reporte->writeHTML($footer);
	$reporte->setFooter('{PAGENO}');
	$reporte->SetTitle('Reporte Financiero desde '.$_POST['desde'].' hasta '.$_POST['hasta']);
	$reporte->Output('Reporte Financiero desde'.$_POST['desde'].' hasta '.$_POST['hasta'].'.pdf', 'I');
	$reporte->Output();
	}else{
		header("location: ?view=3erCronograma&mode=estadoCotizaciones&error=2");
	}
?>