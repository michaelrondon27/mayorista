<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$fecha=date("d-m-Y");
	//////////////////////////           PRODUCTOS          /////////////////////////////////
	$nevera=0; $aire=0; $lavadora=0; $secadora=0; $cocina=0; $horno=0; $tv=0; $freezer=0; $ventilador=0;
	/////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////                MODELOS              //////////////////////////////////////
	//------------------------------              NEVERAS            -----------------------------------//
	$n1=0; $n2=0; $n3=0; $n4=0; $n5=0; $n6=0; $n7=0; $n8=0; $n9=0; $n10=0; $n11=0; $n12=0; $n13=0;
	//--------------------------------------------------------------------------------------------------//
	//- AIRE ACONDICIONADO -//
	$a1=0; $a2=0; $a3=0;
	//---------------------//
	//-- LAVADORAS --//
	$la1=0; $la2=0;
	//--------------//
	//- SECADORAS -//
	$s1=0;
	//-------------//
	//------------------       COCINAS       -------------------//
	$co1=0; $co2=0; $co3=0; $co4=0; $co5=0; $co6=0; $co7=0; $co8=0;
	//-----------------------------------------------------------//
	//-------    HORNO    -------//
	$ho1=0; $ho2=0; $ho3=0; $ho4=0; 
	//---------------------------//
	//- TELEVISORES -//
	$tv1=0; $tv2=0;
	//--------------//
	//-- FREEZER --//
	$f1=0; $f2=0; 
	//------------//
	// VENTILADOR //
	$v1=0;
	//-----------//	
	/////////////////////////////////////////////////////////////////////////////////////////
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="reporte pdf detallado del 4to por fecha desde ".$_POST['desde']." hasta".$_POST['hasta'];
	$event=$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario' '$evento', NOW(), 'REPORTE');");
	$encabezado="
		<div class='contenedor'>
			<div class='logo'>
				<img src='views/app/images/baner.png' width='' height=''>
			</div>
			<div align='center'>
				COMERSSO MAYORISTA<br><br>
			</div>
			<div align=center>
				Reporte de detallado desde ".$_POST['desde']." hasta ".$_POST['hasta']."
			</div>
			<br>
			<div align='center'>
				Fecha: ".$fecha."
			</div>
			<div class='clear'></div>
	";
	$reporte=new mPDF('', 'Letter'); 	
	$reporte->addPage();
	$css=file_get_contents('views/app/css/detallado.css');
	$reporte->writeHTML($css, 1);
	$reporte->writeHTML($encabezado);
	$sql=$db->query("SELECT * FROM almacenadoras_4to;");
	while($data=$db->recorrer($sql)){
		$almacenadora="
			<table>
				<tr>
					<th colspan='4' align='center' class='abajo rojo'>".$data[1]."</th>
				</tr>
		";
		$reporte->writeHTML($almacenadora);
		$sql2=$db->query("SELECT id_cotizacion FROM cotizacion_4to WHERE fecha BETWEEN '$desde' AND '$hasta' AND despacho=1;");
		while($data2=$db->recorrer($sql2)){
			$sql1=$db->query("SELECT id_producto, cantidad, id_modelo FROM ordenes_4to WHERE id_cotizacion=$data2[0] AND id_almacenadora=$data[0];");
			while($data1=$db->recorrer($sql1)){
				if($data1[0]==1){
					$nevera=$nevera+$data1[1];
					if($data1[2]==1){
						$n1=$n1+$data1[1];
					}else if($data1[2]==2){
						$n2=$n2+$data1[1];
					}else if($data1[2]==3){
						$n3=$n3+$data1[1];
					}else if($data1[2]==4){
						$n4=$n4+$data1[1];
					}else if($data1[2]==5){
						$n5=$n5+$data1[1];
					}else if($data1[2]==6){
						$n6=$n6+$data1[1];
					}else if($data1[2]==7){
						$n7=$n7+$data1[1];
					}else if($data1[2]==8){
						$n8=$n8+$data1[1];
					}else if($data1[2]==9){
						$n9=$n9+$data1[1];
					}else if($data1[2]==10){
						$n10=$n10+$data1[1];
					}else if($data1[2]==11){
						$n11=$n11+$data1[1];
					}else if($data1[2]==12){
						$n12=$n12+$data1[1];
					}else if($data1[2]==13){
						$n13=$n13+$data1[1];
					}
				}else if($data1[0]==2){
					$aire=$aire+$data1[1];
					if($data1[2]==14){
						$a1=$a1+$data1[1];
					}else if($data1[2]==15){
						$a2=$a2+$data1[1];
					}else if($data1[2]==16){
						$a3=$a3+$data1[1];
					}
				}else if($data1[0]==3){
					$lavadora=$lavadora+$data1[1];
					if($data1[2]==17){
						$la1=$la1+$data1[1];
					}else if($data1[2]==18){
						$la2=$la2+$data1[1];
					}
				}else if($data1[0]==4){
					$secadora=$secadora+$data1[1];
					if($data1[2]==19){
						$s1=$s1+$data1[1];
					}
				}else if($data1[0]==5){
					$cocina=$cocina+$data1[1];
					if($data1[2]==20){
						$co1=$co1+$data1[1];
					}else if($data1[2]==21){
						$co2=$co2+$data1[1];
					}else if($data1[2]==22){
						$co3=$co3+$data1[1];
					}else if($data1[2]==23){
						$co4=$co4+$data1[1];
					}else if($data1[2]==24){
						$co5=$co5+$data1[1];
					}else if($data1[2]==25){
						$co6=$co6+$data1[1];
					}else if($data1[2]==26){
						$co7=$co7+$data1[1];
					}else if($data1[2]==27){
						$co8=$co8+$data1[1];
					}
				}else if($data1[0]==6){
					$horno=$horno+$data1[1];
					if($data1[2]==28){
						$ho1=$ho1+$data1[1];
					}else if($data1[2]==29){
						$ho2=$ho2+$data1[1];
					}else if($data1[2]==30){
						$ho3=$ho3+$data1[1];
					}else if($data1[2]==31){
						$ho4=$ho4+$data1[1];
					}
				}else if($data1[0]==7){
					$tv=$tv+$data1[1];
					if($data1[2]==32){
						$tv1=$tv1+$data1[1];
					}else if($data1[2]==33){
						$tv2=$tv2+$data1[1];
					}
				}else if($data1[0]==8){
					$freezer=$freezer+$data1[1];
					if($data1[2]==34){
						$f1=$f1+$data1[1];
					}else if($data1[2]==35){
						$f2=$f2+$data1[1];
					}
				}else if($data1[0]==9){
					$ventilador=$ventilador+$data1[1];
					if($data1[2]==36){
						$v1=$v1+$data1[1];
					}
				}
			}
		}
		$productos="
				<tr>
					<td colspan='4' class='abajo gris' align='center'>NEVERA</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>HRF10WNDS: ".$n1."</td>
					<td class='abajo izquierda'>HRF12WNDS: ".$n2."</td>
					<td class='abajo izquierda'>HRF-279F: ".$n3."</td>
					<td class='abajo'>HR-929F: ".$n4."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>HRF-319F: ".$n5."</td>
					<td class='abajo izquierda'>HR-339F: ".$n6."</td>
					<td class='abajo izquierda'>HR-944F: ".$n7."</td>
					<td class='abajo'>HRF-953F: ".$n8."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>HRF-719: ".$n9."</td>
					<td class='abajo izquierda'>HRF-628DS7: ".$n10."</td>
					<td class='abajo izquierda'>HRF-628IS7: ".$n11."</td>
					<td class='abajo'>HB21FB: ".$n12."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo'>HB21FW: ".$n13."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>AIRE ACONDICIONADO</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>ESA418J: ".$a1."</td>
					<td class='abajo izquierda'>HSU-12LEA13-M: ".$a2."</td>
					<td colspan='2' class='abajo'>HSU-18LEA13-M: ".$a3."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>LAVADORA</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>XQB100-9188: ".$la1."</td>
					<td colspan='2' class='abajo'>XQB120-9188: ".$la2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>SECADORA</td>	
				</tr>
				<tr>
					<td colspan='4' class='abajo'>GDE-450AW: ".$s1."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>COCINA</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>KGG5201-A1: ".$co1."</td>
					<td class='abajo izquierda'>KGG6201-A1: ".$co2."</td>
					<td class='abajo izquierda'>KGG5202-A1: ".$co3."</td>
					<td class='abajo'>KGG6202-A1: ".$co4."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>KGG7501-D1: ".$co5."</td>
					<td class='abajo izquierda'>KGG7502-D1: ".$co6."</td>
					<td class='abajo izquierda'>KGG93M1-D1: ".$co7."</td>
					<td class='abajo'>KGG93M2-D1: ".$co8."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>HORNO</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>BM6402-A1-03: ".$ho1."</td>
					<td class='abajo izquierda'>BM6402-A1-00: ".$ho2."</td>
					<td class='abajo izquierda'>BM66T2-A1-11: ".$ho3."</td>
					<td class='abajo'>BM66T2-A1-09: ".$ho4."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>TELEVISOR</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>L32F6: ".$tv1."</td>
					<td colspan='2' class='abajo'>L39F6: ".$tv2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>FREEZER</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>HF09CM10NW: ".$f1."</td>
					<td colspan='2' class='abajo'>HF11CM10NW: ".$f2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>VENTILADOR</td>	
				</tr>
				<tr>
					<td colspan='4' class='abajo'>FS1608: ".$v1."</td>
				</tr>
			</table>
		";
		$reporte->writeHTML($productos);
		if($data[0]==1){
			$reporte->setFooter('{PAGENO}');
			$salto="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			$reporte->writeHTML($salto);
		}else if($data[0]==2 || $data[0]==3 || $data[0]==4){
			$reporte->setFooter('{PAGENO}');
			$salto="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			$reporte->writeHTML($salto);
		}
		////////////////////////////////                MODELOS              //////////////////////////////////////
		//------------------------------              NEVERAS            -----------------------------------//
		$n1=0; $n2=0; $n3=0; $n4=0; $n5=0; $n6=0; $n7=0; $n8=0; $n9=0; $n10=0; $n11=0; $n12=0; $n13=0;
		//--------------------------------------------------------------------------------------------------//
		//- AIRE ACONDICIONADO -//
		$a1=0; $a2=0; $a3=0;
		//---------------------//
		//-- LAVADORAS --//
		$la1=0; $la2=0;
		//--------------//
		//- SECADORAS -//
		$s1=0;
		//-------------//
		//------------------       COCINAS       -------------------//
		$co1=0; $co2=0; $co3=0; $co4=0; $co5=0; $co6=0; $co7=0; $co8=0;
		//-----------------------------------------------------------//
		//-------    HORNO    -------//
		$ho1=0; $ho2=0; $ho3=0; $ho4=0; 
		//---------------------------//
		//- TELEVISORES -//
		$tv1=0; $tv2=0;
		//--------------//
		//-- FREEZER --//
		$f1=0; $f2=0; 
		//------------//
		// VENTILADOR //
		$v1=0;
		//-----------//	
	}
	$footer="
		</div>
	";
	$reporte->writeHTML($footer);
	$reporte->setFooter('{PAGENO}');
	$reporte->SetTitle('Reporte Detallado desde '.$_POST['desde'].' hasta '.$_POST['hasta']);
	$reporte->Output('Reporte Detallado desde'.$_POST['desde'].' hasta '.$_POST['hasta'].'.pdf', 'I');
	$reporte->Output();
?>