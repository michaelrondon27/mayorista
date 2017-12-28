<?php
	require("views/app/libs/PHPExcel/PHPExcel.php");
	$db=new Conexion();
	//VARIABLES DE PHP
	$objPHPExcel=new PHPExcel();
	//DATOS DE LA CONEXION
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Reporte de los beneficiarios en excel";
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'REPORTE');");
	//PROPIEDADES DE ARCHIVO EXCEL
	$objPHPExcel->getProperties()->setCreator("Beneficiarios")
	->setLastModifiedBy("Beneficiarios")
	->setTitle("Reporte XLS")
	->setSubject("Reporte")
	->setDescription("")
	->setKeywords("")
	->setCategory("");
	//PROPIEDADES DE LA CELDA
	$objPHPExcel->getDefaultStyle()->getFont()->setSize('12');
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	//CABECERA DE LA CONSULTA
	$i=1;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$i, "NOMBRE")
	->setCellValue("B".$i, "CEDULA/RIF")
	->setCellValue("C".$i, "DIRECCIÓN")
	->setCellValue("D".$i, "CONTACTO")
	->setCellValue("E".$i, "TELÉFONO")
	->setCellValue("F".$i, "CORREO")
	->setCellValue("G".$i, "OTRO TELÉFONO");
	$objPHPExcel->getActiveSheet()
				->getStyle('A1:G1')
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
				->getStyle('A1:G1')
				->applyFromArray($borders);
	//DETALLE DE LA CONSULTA
	$sql=$db->query("SELECT nombre, rif, direccion, contacto, id_cod_tlf, telefono, correo, id_cod_tlf2, telefono2 FROM empresa ORDER BY nombre;");
	while($data=$db->recorrer($sql)){
		$i++;
		if($data[8]!=""){
			$otro=$_cod_tlf[$data[7]]['cod_tlf']."-".$data[8];
		}else{
			$otro="";
		}
		//BORDE DE LA CELDA
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A'.$i.':G'.$i)
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$i, $data[0])
		->setCellValue("B".$i, $data[1])
		->setCellValue("C".$i, $data[2])
		->setCellValue("D".$i, $data[3])
		->setCellValue("E".$i, $_cod_tlf[$data[4]]['cod_tlf']."-".$data[5])
		->setCellValue("F".$i, $data[6])
		->setCellValue("G".$i, $otro);
	}
	//DATOS DE LA SALIDA DEL EXCEL
	$archivo="Listado De Beneficiario ".date("d-m-Y").".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>