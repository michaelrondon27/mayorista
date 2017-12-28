<?php
	require("views/app/libs/PHPExcel/PHPExcel.php");
	$db=new Conexion();
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
	//VARIABLES DE PHP
	$objPHPExcel=new PHPExcel();
	//DATOS DE LA CONEXION
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$fecha=date("d-m-Y");
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Reporte detallado del 3er cornograma en excel desde ".$desde." hasta ".$hasta;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'REPORTE');");
	//PROPIEDADES DE ARCHIVO EXCEL
	$objPHPExcel->getProperties()->setCreator("Detallado")
	->setLastModifiedBy("Detallado")
	->setTitle("Reporte XLS")
	->setSubject("Reporte")
	->setDescription("")
	->setKeywords("")
	->setCategory("");
	//PROPIEDADES DE LA CELDA
	$sql=$db->query("SELECT * FROM almacenadoras;");
	while($data=$db->recorrer($sql)){
		// Create a new worksheet called "My Data"
		$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $data[1]);
		// Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
		$objPHPExcel->addSheet($myWorkSheet, 0);
		$sql1=$db->query("SELECT id_cotizacion FROM cotizacion WHERE fecha BETWEEN '$desde' AND '$hasta' AND despacho=1;");
		$objPHPExcel->getDefaultStyle()->getFont()->setSize('12');
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		//CABECERA DE LA CONSULTA
		$i=1;
		while($data1=$db->recorrer($sql1)){
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A".$i, "PRODUCTO")
			->setCellValue("B".$i, "MODELO")
			->setCellValue("C".$i, "CANTIDAD");
			$objPHPExcel->getActiveSheet()
						->getStyle('A'.$i.':C'.$i)
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()->setARGB('FFEEEEEE');
			$borders=array(
				'borders'=>array(
					'allborders'=>array(
						'style'=>PHPExcel_Style_Border::BORDER_THIN,
						'color'=>array('argb'=>'FF000000'),
					)
				),
			);
			$objPHPExcel->getActiveSheet()
						->getStyle('A'.$i.':C'.$i)
						->applyFromArray($borders);
			$sql2=$db->query("SELECT id_producto, cantidad, id_modelo FROM ordenes WHERE id_cotizacion=$data1[0] AND id_almacenadora=$data[0];");
			while($data2=$db->recorrer($sql2)){
				if($data2[0]==1){
					$nevera=$nevera+$data2[1];
					if($data2[2]==1){
						$n1=$n1+$data2[1];
					}else if($data2[2]==2){
						$n2=$n2+$data2[1];
					}else if($data2[2]==3){
						$n3=$n3+$data2[1];
					}else if($data2[2]==4){
						$n4=$n4+$data2[1];
					}else if($data2[2]==5){
						$n5=$n5+$data2[1];
					}else if($data2[2]==6){
						$n6=$n6+$data2[1];
					}else if($data2[2]==7){
						$n7=$n7+$data2[1];
					}else if($data2[2]==8){
						$n8=$n8+$data2[1];
					}else if($data2[2]==9){
						$n9=$n9+$data2[1];
					}else if($data2[2]==10){
						$n10=$n10+$data2[1];
					}else if($data2[2]==11){
						$n11=$n11+$data2[1];
					}else if($data2[2]==12){
						$n12=$n12+$data2[1];
					}else if($data2[2]==13){
						$n13=$n13+$data2[1];
					}else if($data2[2]==14){
						$n14=$n14+$data2[1];
					}
				}else if($data2[0]==2){
					$freezer=$freezer+$data2[1];
					if($data2[2]==15){
						$f1=$f1+$data2[1];
					}else if($data2[2]==16){
						$f2=$f2+$data2[1];
					}
				}else if($data2[0]==3){
					$aire=$aire+$data2[1];
					if($data2[2]==17){
						$a1=$a1+$data2[1];
					}else if($data2[2]==18){
						$a2=$a2+$data2[1];
					}else if($data2[2]==19){
						$a3=$a3+$data2[1];
					}else if($data2[2]==20){
						$a4=$a4+$data2[1];
					}else if($data2[2]==21){
						$a5=$a5+$data2[1];
					}
				}else if($data2[0]==4){
					$lavadora=$lavadora+$data2[1];
					if($data2[2]==22){
						$la1=$la1+$data2[1];
					}else if($data2[2]==23){
						$la2=$la2+$data2[1];
					}else if($data2[2]==24){
						$la3=$la3+$data2[1];
					}else if($data2[2]==25){
						$la4=$la4+$data2[1];
					}else if($data2[2]==26){
						$la5=$la5+$data2[1];
					}else if($data2[2]==27){
						$la6=$la6+$data2[1];
					}else if($data2[2]==28){
						$la7=$la7+$data2[1];
					}else if($data2[2]==29){
						$la8=$la8+$data2[1];
					}
				}else if($data2[0]==5){
					$secadora=$secadora+$data2[1];
					if($data2[2]==30){
						$s1=$s1+$data2[1];
					}
				}else if($data2[0]==6){
					$cocina=$cocina+$data2[1];
					if($data2[2]==31){
						$co1=$co1+$data2[1];
					}else if($data2[2]==32){
						$co2=$co2+$data2[1];
					}else if($data2[2]==33){
						$co3=$co3+$data2[1];
					}else if($data2[2]==34){
						$co4=$co4+$data2[1];
					}else if($data2[2]==35){
						$co5=$co5+$data2[1];
					}else if($data2[2]==36){
						$co6=$co6+$data2[1];
					}else if($data2[2]==37){
						$co7=$co7+$data2[1];
					}else if($data2[2]==38){
						$co8=$co8+$data2[1];
					}
				}else if($data2[0]==7){
					$horno=$horno+$data2[1];
					if($data2[2]==39){
						$ho1=$ho1+$data2[1];
					}else if($data2[2]==40){
						$ho2=$ho2+$data2[1];
					}else if($data2[2]==41){
						$ho3=$ho3+$data2[1];
					}else if($data2[2]==42){
						$ho4=$ho4+$data2[1];
					}
				}else if($data2[0]==8){
					$tope=$tope+$data2[1];
					if($data2[2]==43){
						$to1=$to1+$data2[1];
					}else if($data2[2]==44){
						$to2=$to2+$data2[1];
					}else if($data2[2]==45){
						$to3=$to3+$data2[1];
					}
				}else if($data2[0]==9){
					$campana=$campana+$data2[1];
					if($data2[2]==46){
						$ca1=$ca1+$data2[1];
					}else if($data2[2]==47){
						$ca2=$ca2+$data2[1];
					}
				}else if($data2[0]==10){
					$tv=$tv+$data2[1];
					if($data2[2]==48){
						$tv1=$tv1+$data2[1];
					}else if($data2[2]==49){
						$tv2=$tv2+$data2[1];
					}else if($data2[2]==50){
						$tv3=$tv3+$data2[1];
					}else if($data2[2]==51){
						$tv4=$tv4+$data2[1];
					}else if($data2[2]==52){
						$tv5=$tv5+$data2[1];
					}else if($data2[2]==53){
						$tv6=$tv6+$data2[1];
					}else if($data2[2]==54){
						$tv7=$tv7+$data2[1];
					}
				}else if($data2[0]==11){
					$cafetera=$cafetera+$data2[1];
					if($data2[2]==55){
						$caf1=$caf1+$data2[1];
					}else if($data2[2]==56){
						$caf2=$caf2+$data2[1];
					}
				}else if($data2[0]==12){
					$hervidor=$hervidor+$data2[1];
					if($data2[2]==57){
						$he1=$he1+$data2[1];
					}else if($data2[2]==58){
						$he2=$he2+$data2[1];
					}
				}else if($data2[0]==13){
					$licuadora=$licuadora+$data2[1];
					if($data2[2]==59){
						$li1=$li1+$data2[1];
					}else if($data2[2]==60){
						$li2=$li2+$data2[1];
					}
				}else if($data2[0]==14){
					$microonda=$microonda+$data2[1];
					if($data2[2]==61){
						$m1=$m1+$data2[1];
					}else if($data2[2]==62){
						$m2=$m2+$data2[1];
					}else if($data2[2]==63){
						$m3=$m3+$data2[1];
					}
				}else if($data2[0]==15){
					$ventilador=$ventilador+$data2[1];
					if($data2[2]==64){
						$v1=$v1+$data2[1];
					}else if($data2[2]==65){
						$v2=$v2+$data2[1];
					}
				}
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A2:C2')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A2:C2')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A2", "NEVERA")
		->setCellValue("B2", "HRF10WNDS")
		->setCellValue("C2", $n1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A3:C3')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A3", "")
		->setCellValue("B3", "HRF12WNDS")
		->setCellValue("C3", $n2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A4:C4')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A4", "")
		->setCellValue("B4", "HRF-279F")
		->setCellValue("C4", $n3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A5:C5')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A5", "")
		->setCellValue("B5", "HR-929F")
		->setCellValue("C5", $n4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A6:C6')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A6", "")
		->setCellValue("B6", "HR-319F")
		->setCellValue("C6", $n5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A7:C7')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A7", "")
		->setCellValue("B7", "HR-933F")
		->setCellValue("C7", $n6);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A8:C8')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A8", "")
		->setCellValue("B8", "HR-339F")
		->setCellValue("C8", $n7);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A9:C9')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A9", "")
		->setCellValue("B9", "HR-944F")
		->setCellValue("C9", $n8);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A10:C10')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A10", "")
		->setCellValue("B10", "HRF-953F")
		->setCellValue("C10", $n9);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A11:C11')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A11", "")
		->setCellValue("B11", "HRF-719")
		->setCellValue("C11", $n10);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A12:C12')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A12", "")
		->setCellValue("B12", "HRF-628DS7")
		->setCellValue("C12", $n11);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A13:C13')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A13", "")
		->setCellValue("B13", "HRF-628IS7")
		->setCellValue("C13", $n12);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A14:C14')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A14", "")
		->setCellValue("B14", "HB21FB")
		->setCellValue("C14", $n13);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A15:C15')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A15", "")
		->setCellValue("B15", "HB21FW")
		->setCellValue("C15", $n14);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A16:C16')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A16:C16')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A16", "FREEZER")
		->setCellValue("B16", "HF09CM10NW")
		->setCellValue("C16", $f1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A17:C17')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A17", "")
		->setCellValue("B17", "HF11CM10NW")
		->setCellValue("C17", $f2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A18:C18')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A18:C18')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A18", "AIRE ACONDICIONADO")
		->setCellValue("B18", "ESA412J")
		->setCellValue("C18", $a1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A19:C19')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A19", "")
		->setCellValue("B19", "ESA415J")
		->setCellValue("C19", $a2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A20:C20')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A20", "")
		->setCellValue("B20", "ESA418J")
		->setCellValue("C20", $a3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A21:C21')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A21", "")
		->setCellValue("B21", "HSU-12LEA13-M")
		->setCellValue("C21", $a4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A22:C22')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A22", "")
		->setCellValue("B22", "HSU-18LEA13-M")
		->setCellValue("C22", $a5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A23:C23')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A23:C23')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A23", "LAVADORA")
		->setCellValue("B23", "HWM70-0713S")
		->setCellValue("C23", $la1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A24:C24')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A24", "")
		->setCellValue("B24", "HWM100-1187S")
		->setCellValue("C24", $la2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A25:C25')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A25", "")
		->setCellValue("B25", "HWM150-0623S")
		->setCellValue("C25", $la3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A26:C26')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A26", "")
		->setCellValue("B26", "HWM150-0523M")
		->setCellValue("C26", $la4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A27:C27')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A27", "")
		->setCellValue("B27", "XQB65-918")
		->setCellValue("C27", $la5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A28:C28')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A28", "")
		->setCellValue("B28", "XQB75-918")
		->setCellValue("C28", $la6);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A29:C29')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A29", "")
		->setCellValue("B29", "XQB100-9188")
		->setCellValue("C29", $la7);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A30:C30')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A30", "")
		->setCellValue("B30", "XQB120-9188")
		->setCellValue("C30", $la8);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A31:C31')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A31:C31')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A31", "SECADORA")
		->setCellValue("B31", "GDE450AW")
		->setCellValue("C31", $s1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A32:C32')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A32:C32')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A32", "COCINA")
		->setCellValue("B32", "KGG5201-A1")
		->setCellValue("C32", $co1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A33:C33')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A33", "")
		->setCellValue("B33", "KGG6201-A1")
		->setCellValue("C33", $co2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A34:C34')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A34", "")
		->setCellValue("B34", "KGG5202-A1")
		->setCellValue("C34", $co3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A35:C35')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A35", "")
		->setCellValue("B35", "KGG6202-A1")
		->setCellValue("C35", $co4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A36:C36')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A36", "")
		->setCellValue("B36", "KGG7501-D1")
		->setCellValue("C36", $co5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A37:C37')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A37", "")
		->setCellValue("B37", "KGG7502-D1")
		->setCellValue("C37", $co6);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A38:C38')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A38", "")
		->setCellValue("B38", "KGG93M1-D1")
		->setCellValue("C38", $co7);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A39:C39')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A39", "")
		->setCellValue("B39", "KGG93M2-D1")
		->setCellValue("C39", $co8);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A40:C40')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A40:C40')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A40", "HORNO")
		->setCellValue("B40", "BM6402-A1-03")
		->setCellValue("C40", $ho1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A41:C41')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A41", "")
		->setCellValue("B41", "BM6402-A1-00")
		->setCellValue("C41", $ho2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A42:C42')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A42", "")
		->setCellValue("B42", "BM66T2-A1-11")
		->setCellValue("C42", $ho3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A43:C43')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A43", "")
		->setCellValue("B43", "BM66T2-A1-09")
		->setCellValue("C43", $ho4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A44:C44')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A44:C44')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A44", "TOPE DE COCINA")
		->setCellValue("B44", "XFS6400-A1")
		->setCellValue("C44", $to1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A45:C45')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A45", "")
		->setCellValue("B45", "XFS6400-B1")
		->setCellValue("C45", $to2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A46:C46')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A46", "")
		->setCellValue("B46", "XFS6400-C1")
		->setCellValue("C46", $to3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A47:C47')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A47:C47')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A47", "CAMPANA")
		->setCellValue("B47", "QD60A-G3")
		->setCellValue("C47", $ca1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A48:C48')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A48", "")
		->setCellValue("B48", "QD76A-G3T")
		->setCellValue("C48", $ca2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A49:C49')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A49:C49')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A49", "TELEVISOR")
		->setCellValue("B49", "L32F6")
		->setCellValue("C49", $tv1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A50:C50')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A50", "")
		->setCellValue("B50", "32Z58")
		->setCellValue("C50", $tv2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A51:C51')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A51", "")
		->setCellValue("B51", "L39F6")
		->setCellValue("C51", $tv3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A52:C52')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A52", "")
		->setCellValue("B52", "39Z58")
		->setCellValue("C52", $tv4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A53:C53')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A53", "")
		->setCellValue("B53", "48YCALED")
		->setCellValue("C53", $tv5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A54:C54')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A54", "")
		->setCellValue("B54", "50YCALED")
		->setCellValue("C54", $tv6);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A55:C55')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A55", "")
		->setCellValue("B55", "55DS2")
		->setCellValue("C55", $tv7);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A56:C56')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A56:C56')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A56", "CAFETERA")
		->setCellValue("B56", "HDM-2310")
		->setCellValue("C56", $caf1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A57:C57')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A57", "")
		->setCellValue("B57", "HDM-2311R")
		->setCellValue("C57", $caf2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A58:C58')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A58:C58')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A58", "HERVIDOR")
		->setCellValue("B58", "HKT-2110")
		->setCellValue("C58", $he1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A59:C59')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A59", "")
		->setCellValue("B59", "HKT-2111R")
		->setCellValue("C59", $he2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A60:C60')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A60:C60')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A60", "LICUADORA")
		->setCellValue("B60", "HBL-2120")
		->setCellValue("C60", $li1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A61:C61')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A61", "")
		->setCellValue("B61", "HBL-2121R")
		->setCellValue("C61", $li2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A62:C62')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A62:C62')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A62", "MICROONDA")
		->setCellValue("B62", "HGN-2070PSR")
		->setCellValue("C62", $m1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A63:C63')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A63", "")
		->setCellValue("B63", "HAS-2280EGTB")
		->setCellValue("C63", $m2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A64:C64')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A64", "")
		->setCellValue("B64", "HSC-3190EGCT")
		->setCellValue("C64", $m3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A65:C65')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A65:C65')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A65", "VENTILADOR")
		->setCellValue("B65", "FS1608S")
		->setCellValue("C65", $v1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A66:C66')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A66", "")
		->setCellValue("B66", "M-18")
		->setCellValue("C66", $v2);
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
	}
	//DATOS DE LA SALIDA DEL EXCEL
	$archivo="Listado detellado de los productos del 3er cronograma desde ".$_POST['desde']." hasta ".$_POST['hasta'].".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>