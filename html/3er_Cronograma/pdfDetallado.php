<?php
	require("views/app/libs/mpdf/mpdf.php");
	$db=new Conexion();
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$fecha=date("d-m-Y");
	//////////////////////////           PRODUCTOS          /////////////////////////////////
	$nevera=0; $freezer=0; $aire=0; $lavadora=0; $secadora=0; $cocina=0; $horno=0; $tope=0;
	$campana=0; $tv=0; $cafetera=0;	$hervidor=0; $licuadora=0; $microonda=0; $ventilador=0;
	/////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////                MODELOS              //////////////////////////////////////
	//------------------------------              NEVERAS            -----------------------------------//
	$n1=0; $n2=0; $n3=0; $n4=0; $n5=0; $n6=0; $n7=0; $n8=0; $n9=0; $n10=0; $n11=0; $n12=0; $n13=0; $n14=0;
	//--------------------------------------------------------------------------------------------------//
	//-- FREEZER --//
	$f1=0; $f2=0; 
	//------------//
	//----- AIRE ACONDICIONADO -----//
	$a1=0; $a2=0; $a3=0; $a4=0; $a5=0;
	//------------------------------//
	//------------------       LAVADORAS       -------------------//
	$la1=0; $la2=0; $la3=0; $la4=0; $la5=0; $la6=0; $la7=0; $la8=0;
	//-----------------------------------------------------------//
	//- SECADORAS -//
	$s1=0;
	//-------------//
	//------------------       COCINAS       -------------------//
	$co1=0; $co2=0; $co3=0; $co4=0; $co5=0; $co6=0; $co7=0; $co8=0;
	//-----------------------------------------------------------//
	//-------    HORNO    -------//
	$ho1=0; $ho2=0; $ho3=0; $ho4=0; 
	//---------------------------//
	//------  TOPE  ------//
	$to1=0; $to2=0; $to3=0;
	//-------------------//
	//- CAMPANA -//
	$ca1=0; $ca2=0;
	//-----------//
	//----------------    TELEVISORES     ---------------//
	$tv1=0; $tv2=0; $tv3=0; $tv4=0; $tv5=0; $tv6=0; $tv7=0;
	//---------------------------------------------------//
	//-- CAFETERA --//
	$caf1=0; $caf2=0;
	//-------------//
	//- HERVIDOR -//
	$he1=0; $he2=0;
	//-----------//
	// LICUADORA //
	$li1=0; $li2=0;
	//-----------//
	//-- MICROONDAS --//
	$m1=0; $m2=0; $m3=0;
	//----------------//
	// VENTILADOR //
	$v1=0; $v2=0;
	//-----------//
	/////////////////////////////////////////////////////////////////////////////////////////
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="reporte pdf detallado del 3er por fecha desde ".$_POST['desde']." hasta".$_POST['hasta'];
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
	$sql=$db->query("SELECT * FROM almacenadoras;");
	while($data=$db->recorrer($sql)){
		$almacenadora="
			<table>
				<tr>
					<th colspan='4' align='center' class='abajo rojo'>".$data[1]."</th>
				</tr>
		";
		$reporte->writeHTML($almacenadora);
		$sql2=$db->query("SELECT id_cotizacion FROM cotizacion WHERE fecha BETWEEN '$desde' AND '$hasta' AND despacho=1;");
		while($data2=$db->recorrer($sql2)){
			$sql1=$db->query("SELECT id_producto, cantidad, id_modelo FROM ordenes WHERE id_cotizacion=$data2[0] AND id_almacenadora=$data[0];");
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
					}else if($data1[2]==14){
						$n14=$n14+$data1[1];
					}
				}else if($data1[0]==2){
					$freezer=$freezer+$data1[1];
					if($data1[2]==15){
						$f1=$f1+$data1[1];
					}else if($data1[2]==16){
						$f2=$f2+$data1[1];
					}
				}else if($data1[0]==3){
					$aire=$aire+$data1[1];
					if($data1[2]==17){
						$a1=$a1+$data1[1];
					}else if($data1[2]==18){
						$a2=$a2+$data1[1];
					}else if($data1[2]==19){
						$a3=$a3+$data1[1];
					}else if($data1[2]==20){
						$a4=$a4+$data1[1];
					}else if($data1[2]==21){
						$a5=$a5+$data1[1];
					}
			}else if($data1[0]==4){
					$lavadora=$lavadora+$data1[1];
					if($data1[2]==22){
						$la1=$la1+$data1[1];
					}else if($data1[2]==23){
						$la2=$la2+$data1[1];
					}else if($data1[2]==24){
						$la3=$la3+$data1[1];
					}else if($data1[2]==25){
						$la4=$la4+$data1[1];
					}else if($data1[2]==26){
						$la5=$la5+$data1[1];
					}else if($data1[2]==27){
						$la6=$la6+$data1[1];
					}else if($data1[2]==28){
						$la7=$la7+$data1[1];
					}else if($data1[2]==29){
						$la8=$la8+$data1[1];
					}
				}else if($data1[0]==5){
					$secadora=$secadora+$data1[1];
					if($data1[2]==30){
						$s1=$s1+$data1[1];
					}
				}else if($data1[0]==6){
					$cocina=$cocina+$data1[1];
					if($data1[2]==31){
						$co1=$co1+$data1[1];
					}else if($data1[2]==32){
						$co2=$co2+$data1[1];
					}else if($data1[2]==33){
						$co3=$co3+$data1[1];
					}else if($data1[2]==34){
						$co4=$co4+$data1[1];
					}else if($data1[2]==35){
						$co5=$co5+$data1[1];
					}else if($data1[2]==36){
						$co6=$co6+$data1[1];
					}else if($data1[2]==37){
						$co7=$co7+$data1[1];
					}else if($data1[2]==38){
						$co8=$co8+$data1[1];
					}
				}else if($data1[0]==7){
					$horno=$horno+$data1[1];
					if($data1[2]==39){
						$ho1=$ho1+$data1[1];
					}else if($data1[2]==40){
						$ho2=$ho2+$data1[1];
					}else if($data1[2]==41){
						$ho3=$ho3+$data1[1];
					}else if($data1[2]==42){
						$ho4=$ho4+$data1[1];
					}
				}else if($data1[0]==8){
					$tope=$tope+$data1[1];
					if($data1[2]==43){
						$to1=$to1+$data1[1];
					}else if($data1[2]==44){
						$to2=$to2+$data1[1];
					}else if($data1[2]==45){
						$to3=$to3+$data1[1];
					}
				}else if($data1[0]==9){
					$campana=$campana+$data1[1];
					if($data1[2]==46){
						$ca1=$ca1+$data1[1];
					}else if($data1[2]==47){
						$ca2=$ca2+$data1[1];
					}
				}else if($data1[0]==10){
					$tv=$tv+$data1[1];
					if($data1[2]==48){
						$tv1=$tv1+$data1[1];
					}else if($data1[2]==49){
						$tv2=$tv2+$data1[1];
					}else if($data1[2]==50){
						$tv3=$tv3+$data1[1];
					}else if($data1[2]==51){
						$tv4=$tv4+$data1[1];
					}else if($data1[2]==52){
						$tv5=$tv5+$data1[1];
					}else if($data1[2]==53){
						$tv6=$tv6+$data1[1];
					}else if($data1[2]==54){
						$tv7=$tv7+$data1[1];
					}
				}else if($data1[0]==11){
					$cafetera=$cafetera+$data1[1];
					if($data1[2]==55){
						$caf1=$caf1+$data1[1];
					}else if($data1[2]==56){
						$caf2=$caf2+$data1[1];
					}
				}else if($data1[0]==12){
					$hervidor=$hervidor+$data1[1];
					if($data1[2]==57){
						$he1=$he1+$data1[1];
					}else if($data1[2]==58){
						$he2=$he2+$data1[1];
					}
				}else if($data1[0]==13){
					$licuadora=$licuadora+$data1[1];
					if($data1[2]==59){
						$li1=$li1+$data1[1];
					}else if($data1[2]==60){
						$li2=$li2+$data1[1];
					}
				}else if($data1[0]==14){
					$microonda=$microonda+$data1[1];
					if($data1[2]==61){
						$m1=$m1+$data1[1];
					}else if($data1[2]==62){
						$m2=$m2+$data1[1];
					}else if($data1[2]==63){
						$m3=$m3+$data1[1];
					}
				}else if($data1[0]==15){
					$ventilador=$ventilador+$data1[1];
					if($data1[2]==64){
						$v1=$v1+$data1[1];
					}else if($data1[2]==65){
						$v2=$v2+$data1[1];
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
					<td class='abajo izquierda'>HR-319F: ".$n5."</td>
					<td class='abajo izquierda'>HR-933F: ".$n6."</td>
					<td class='abajo izquierda'>HR-339F: ".$n7."</td>
					<td class='abajo'>HR-944F: ".$n8."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>HRF-953F: ".$n9."</td>
					<td class='abajo izquierda'>HRF-719: ".$n10."</td>
					<td class='abajo izquierda'>HRF-628DS7: ".$n11."</td>
					<td class='abajo'>HRF-628IS7: ".$n12."</td>
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>HB21FB: ".$n13."</td>
					<td colspan='2' class='abajo'>HB21FW: ".$n14."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>FREEZER</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>HF09CM10NW: ".$f1."</td>
					<td colspan='2' class='abajo'>HF11CM10NW: ".$f2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>AIRE ACONDICIONADO</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>ESA412J: ".$a1."</td>
					<td class='abajo izquierda'>ESA415J: ".$a2."</td>
					<td class='abajo izquierda'>ESA418J: ".$a3."</td>
					<td class='abajo'>HSU-12LEA13-M: ".$a4."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo'>HSU-18LEA13-M: ".$a5."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>LAVADORA</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>HWM70-0713S: ".$la1."</td>
					<td class='abajo izquierda'>HWM100-1187S: ".$la2."</td>
					<td class='abajo izquierda'>HWM150-0623S: ".$la3."</td>
					<td class='abajo'>HWM150-0523M: ".$la4."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>XQB65-918: ".$la5."</td>
					<td class='abajo izquierda'>XQB75-918: ".$la6."</td>
					<td class='abajo izquierda'>XQB100-9188: ".$la7."</td>
					<td class='abajo'>XQB120-9188: ".$la8."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>SECADORA</td>	
				</tr>
				<tr>
					<td colspan='4' class='abajo'>GDE450AW: ".$s1."</td>
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
					<td colspan='4' class='abajo gris' align='center'>TOPE DE COCINA</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>XFS6400-A1: ".$to1."</td>
					<td class='abajo izquierda'>XFS6400-B1: ".$to2."</td>
					<td colspan='2' class='abajo'>XFS6400-C1: ".$to3."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>CAMPANA</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>QD60A-G3: ".$ca1."</td>
					<td colspan='2' class='abajo'>QD76A-G3T: ".$ca2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>TELEVISOR</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>L32F6: ".$tv1."</td>
					<td class='abajo izquierda'>32Z58: ".$tv2."</td>
					<td class='abajo izquierda'>L39F6: ".$tv3."</td>
					<td class='abajo'>39Z58: ".$tv4."</td>
				</tr>
				<tr>
					<td class='abajo izquierda'>48YCALED: ".$tv5."</td>
					<td class='abajo izquierda'>50YCALED: ".$tv6."</td>
					<td colspan='2' class='abajo'>55DS2: ".$tv7."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>CAFETERA</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>HDM-2310: ".$caf1."</td>
					<td colspan='2' class='abajo'>HDM-2311R: ".$caf2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>HERVIDOR</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>HKT-2110: ".$he1."</td>
					<td colspan='2' class='abajo'>HKT-2111R: ".$he2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>LICUADORA</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>HBL-2120: ".$li1."</td>
					<td colspan='2' class='abajo'>HBL-2121R: ".$li2."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>MICROONDA</td>	
				</tr>
				<tr>
					<td class='abajo izquierda'>HGN-2070PSR: ".$m1."</td>
					<td class='abajo izquierda'>HAS-2280EGTB: ".$m2."</td>
					<td colspan='2' class='abajo'>HSC-3190EGCT: ".$m3."</td>
				</tr>
				<tr>
					<td colspan='4' class='abajo gris' align='center'>VENTILADOR</td>	
				</tr>
				<tr>
					<td colspan='2' class='abajo izquierda'>FS1608S: ".$v1."</td>
					<td colspan='2' class='abajo'>M-18: ".$v2."</td>
				</tr>
			</table>
		";
		$reporte->writeHTML($productos);
		if($data[0]==1){
			$reporte->setFooter('{PAGENO}');
			$salto="<br><br>";
			$reporte->writeHTML($salto);
		}else if($data[0]==2 || $data[0]==3 || $data[0]==4 || $data[0]==5){
			$reporte->setFooter('{PAGENO}');
			$salto="<br><br><br><br><br><br>";
			$reporte->writeHTML($salto);
		}
		//------------------------------              NEVERAS            -----------------------------------//
		$n1=0; $n2=0; $n3=0; $n4=0; $n5=0; $n6=0; $n7=0; $n8=0; $n9=0; $n10=0; $n11=0; $n12=0; $n13=0; $n14=0;
		//--------------------------------------------------------------------------------------------------//
		//-- FREEZER --//
		$f1=0; $f2=0; 
		//------------//
		//----- AIRE ACONDICIONADO -----//
		$a1=0; $a2=0; $a3=0; $a4=0; $a5=0;
		//------------------------------//
		//------------------       LAVADORAS       -------------------//
		$la1=0; $la2=0; $la3=0; $la4=0; $la5=0; $la6=0; $la7=0; $la8=0;
		//-----------------------------------------------------------//
		//- SECADORAS -//
		$s1=0;
		//-------------//
		//------------------       COCINAS       -------------------//
		$co1=0; $co2=0; $co3=0; $co4=0; $co5=0; $co6=0; $co7=0; $co8=0;
		//-----------------------------------------------------------//
		//-------    HORNO    -------//
		$ho1=0; $ho2=0; $ho3=0; $ho4=0; 
		//---------------------------//
		//------  TOPE  ------//
		$to1=0; $to2=0; $to3=0;
		//-------------------//
		//- CAMPANA -//
		$ca1=0; $ca2=0;
		//-----------//
		//----------------    TELEVISORES     ---------------//
		$tv1=0; $tv2=0; $tv3=0; $tv4=0; $tv5=0; $tv6=0; $tv7=0;
		//---------------------------------------------------//
		//-- CAFETERA --//
		$caf1=0; $caf2=0;
		//-------------//
		//- HERVIDOR -//
		$he1=0; $he2=0;
		//-----------//
		// LICUADORA //
		$li1=0; $li2=0;
		//-----------//
		//-- MICROONDAS --//
		$m1=0; $m2=0; $m3=0;
		//----------------//
		// VENTILADOR //
		$v1=0; $v2=0;
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