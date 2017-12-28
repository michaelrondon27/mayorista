<?php
	require("views/app/libs/PHPExcel/PHPExcel.php");
	$db=new Conexion();
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
	//VARIABLES DE PHP
	$objPHPExcel=new PHPExcel();
	//DATOS DE LA CONEXION
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$fecha=date("d-m-Y");
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Reporte detallado del 4to cornograma en excel desde ".$desde." hasta ".$hasta;
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
	$sql=$db->query("SELECT * FROM almacenadoras_4to;");
	while($data=$db->recorrer($sql)){
		// Create a new worksheet called "My Data"
		$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $data[1]);
		// Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
		$objPHPExcel->addSheet($myWorkSheet, 0);
		$sql1=$db->query("SELECT id_cotizacion FROM cotizacion_4to WHERE fecha BETWEEN '$desde' AND '$hasta' AND despacho=1;");
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
			$sql2=$db->query("SELECT id_producto, cantidad, id_modelo FROM ordenes_4to WHERE id_cotizacion=$data1[0] AND id_almacenadora=$data[0];");
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
					}
				}else if($data2[0]==2){
					$aire=$aire+$data2[1];
					if($data2[2]==14){
						$a1=$a1+$data2[1];
					}else if($data2[2]==15){
						$a2=$a2+$data2[1];
					}else if($data2[2]==16){
						$a3=$a3+$data2[1];
					}
				}else if($data2[0]==3){
					$lavadora=$lavadora+$data2[1];
					if($data2[2]==17){
						$la1=$la1+$data2[1];
					}else if($data2[2]==18){
						$la2=$la2+$data2[1];
					}
				}else if($data2[0]==4){
					$secadora=$secadora+$data2[1];
					if($data2[2]==19){
						$s1=$s1+$data2[1];
					}
				}else if($data2[0]==5){
					$cocina=$cocina+$data2[1];
					if($data2[2]==20){
						$co1=$co1+$data2[1];
					}else if($data2[2]==21){
						$co2=$co2+$data2[1];
					}else if($data2[2]==22){
						$co3=$co3+$data2[1];
					}else if($data2[2]==23){
						$co4=$co4+$data2[1];
					}else if($data2[2]==24){
						$co5=$co5+$data2[1];
					}else if($data2[2]==25){
						$co6=$co6+$data2[1];
					}else if($data2[2]==26){
						$co7=$co7+$data2[1];
					}else if($data2[2]==27){
						$co8=$co8+$data2[1];
					}
				}else if($data2[0]==6){
					$horno=$horno+$data2[1];
					if($data2[2]==28){
						$ho1=$ho1+$data2[1];
					}else if($data2[2]==29){
						$ho2=$ho2+$data2[1];
					}else if($data2[2]==30){
						$ho3=$ho3+$data2[1];
					}else if($data2[2]==31){
						$ho4=$ho4+$data2[1];
					}
				}else if($data2[0]==7){
					$tv=$tv+$data2[1];
					if($data2[2]==32){
						$tv1=$tv1+$data2[1];
					}else if($data2[2]==33){
						$tv2=$tv2+$data2[1];
					}
				}else if($data2[0]==8){
					$freezer=$freezer+$data2[1];
					if($data2[2]==34){
						$f1=$f1+$data2[1];
					}else if($data2[2]==35){
						$f2=$f2+$data2[1];
					}
				}else if($data2[0]==9){
					$ventilador=$ventilador+$data2[1];
					if($data2[2]==36){
						$v1=$v1+$data2[1];
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
		->setCellValue("B6", "HRF-319F")
		->setCellValue("C6", $n5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A7:C7')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A7", "")
		->setCellValue("B7", "HR-339F")
		->setCellValue("C7", $n6);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A8:C8')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A8", "")
		->setCellValue("B8", "HR-944F")
		->setCellValue("C8", $n7);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A9:C9')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A9", "")
		->setCellValue("B9", "HRF-953F")
		->setCellValue("C9", $n8);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A10:C10')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A10", "")
		->setCellValue("B10", "HRF-719")
		->setCellValue("C10", $n9);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A11:C11')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A11", "")
		->setCellValue("B11", "HRF-628DS7")
		->setCellValue("C11", $n10);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A12:C12')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A12", "")
		->setCellValue("B12", "HRF-628IS7")
		->setCellValue("C12", $n11);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A13:C13')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A13", "")
		->setCellValue("B13", "HB21FB")
		->setCellValue("C13", $n12);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A14:C14')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A14", "")
		->setCellValue("B14", "HB21FW")
		->setCellValue("C14", $n13);

		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A15:C15')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A15:C15')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A15", "AIRE ACONDICIONADO")
		->setCellValue("B15", "ESA418J")
		->setCellValue("C15", $a1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A16:C16')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A16", "")
		->setCellValue("B16", "HSU-12LEA13-M")
		->setCellValue("C16", $a2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A17:C17')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A17", "")
		->setCellValue("B17", "HSU-18LEA13-M")
		->setCellValue("C17", $a3);

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
		->setCellValue("A18", "LAVADORA")
		->setCellValue("B18", "XQB100-9188")
		->setCellValue("C18", $la1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A19:C19')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A19", "")
		->setCellValue("B19", "XQB120-9188")
		->setCellValue("C19", $la2);
		
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A20:C20')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A20:C20')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A20", "SECADORA")
		->setCellValue("B20", "GDE-450AW")
		->setCellValue("C20", $s1);

		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A21:C21')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A21:C21')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A21", "COCINA")
		->setCellValue("B21", "KGG5201-A1")
		->setCellValue("C21", $co1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A22:C22')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A22", "")
		->setCellValue("B22", "KGG6201-A1")
		->setCellValue("C22", $co2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A23:C23')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A23", "")
		->setCellValue("B23", "KGG5202-A1")
		->setCellValue("C23", $co3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A24:C24')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A24", "")
		->setCellValue("B24", "KGG6202-A1")
		->setCellValue("C24", $co4);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A25:C25')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A25", "")
		->setCellValue("B25", "KGG7501-D1")
		->setCellValue("C25", $co5);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A26:C26')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A26", "")
		->setCellValue("B26", "KGG7502-D1")
		->setCellValue("C26", $co6);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A27:C27')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A27", "")
		->setCellValue("B27", "KGG93M1-D1")
		->setCellValue("C27", $co7);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A28:C28')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A28", "")
		->setCellValue("B28", "KGG93M2-D1")
		->setCellValue("C28", $co8);

		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A29:C29')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A29:C29')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A29", "HORNO")
		->setCellValue("B29", "BM6402-A1-03")
		->setCellValue("C29", $ho1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A30:C30')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A30", "")
		->setCellValue("B30", "BM6402-A1-00")
		->setCellValue("C30", $ho2);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A31:C31')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A31", "")
		->setCellValue("B31", "BM66T2-A1-11")
		->setCellValue("C31", $ho3);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A32:C32')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A32", "")
		->setCellValue("B32", "BM66T2-A1-09")
		->setCellValue("C32", $ho4);

		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A33:C33')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A33:C33')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A33", "TELEVISOR")
		->setCellValue("B33", "L32F6")
		->setCellValue("C33", $tv1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A34:C34')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A34", "")
		->setCellValue("B34", "L39F6")
		->setCellValue("C34", $tv2);

		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A35:C35')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A35:C35')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A35", "FREEZER")
		->setCellValue("B35", "HF09CM10NW")
		->setCellValue("C35", $f1);
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A36:C36')
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A36", "")
		->setCellValue("B36", "HF11CM10NW")
		->setCellValue("C36", $f2);

		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A37:C37')
		->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()
					->getStyle('A37:C37')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFEEEEEE');
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A37", "VENTILADOR")
		->setCellValue("B37", "FS1608")
		->setCellValue("C37", $v1);

		//////////////////////////           PRODUCTOS          /////////////////////////////////
		$nevera=0; $freezer=0; $aire=0; $lavadora=0; $secadora=0; $cocina=0; $horno=0; $tope=0;
		$campana=0; $tv=0; $cafetera=0;	$hervidor=0; $licuadora=0; $microonda=0; $ventilador=0;
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
	}
	//DATOS DE LA SALIDA DEL EXCEL
	$archivo="Listado detellado de los productos del 4to cronograma desde ".$_POST['desde']." hasta ".$_POST['hasta'].".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>