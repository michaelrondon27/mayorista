<?php
	require_once("views/app/libs/PHPExcel/PHPExcel.php");
	$db=new Conexion();
	//VARIABLES DE PHP
	$objPHPExcel=new PHPExcel();
	//DATOS DE LA CONEXION
	$desde=date("Y-m-d", strtotime($_POST['desde']));
	$hasta=date("Y-m-d", strtotime($_POST['hasta']));
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="reporte excel de cotizacion por fecha desde ".$_POST['desde']." hasta".$_POST['hasta'];
	$event=$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario' '$evento', NOW(), 'REPORTE');");
	//PROPIEDADES DE ARCHIVO EXCEL
	$objPHPExcel->getProperties()->setCreator("Cotizacion")
	->setLastModifiedBy("Cotizacion")
	->setTitle("Reporte XLS")
	->setSubject("Reporte")
	->setDescription("")
	->setKeywords("")
	->setCategory("");
	//PROPIEDADES DE LA CELDA
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize('12');
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	//CABECERA DE LA CONSULTA
	$i=1;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$i, "FECHA")
	->setCellValue("B".$i, "BENEFICIARIO")
	->setCellValue("C".$i, "N° COTIZACION")
	->setCellValue("D".$i, "CANTIDAD")
	->setCellValue("E".$i, "TOTAL");
	$objPHPExcel->getActiveSheet()
				->getStyle('A1:E1')
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
				->getStyle('A1:E1')
				->applyFromArray($borders);
	//DETALLE DE LA CONSULTA
	$sql=$db->query("SELECT c.cotizacion, c.fecha, c.total, c.total_num, e.nombre, c.unidades_total FROM cotizacion c INNER JOIN empresa e ON c.id_empresa=e.id_empresa WHERE c.fecha BETWEEN '$desde' AND '$hasta' ORDER BY c.fecha;");
	$cantidad=0;
	$total=0;
	while($data=$db->recorrer($sql)){
		$fecha=date("d-m-Y", strtotime($data[1]));
		$i++;
		//BORDE DE LA CELDA
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A'.$i.':E'.$i)
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$i, $fecha)
		->setCellValue("B".$i, $data[4])
		->setCellValue("C".$i, $data[0])
		->setCellValue("D".$i, $data[5])
		->setCellValue("E".$i, $data[2]);
		$cantidad=$cantidad+$data[5];
		$total=$total+$data[3];
	}
	$i=$i+1;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$i.':E'.$i)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("C".$i, "Cantidad total:")
	->setCellValue("D".$i, $cantidad);
	$i=$i+1;
	$total=number_format($total, 2, ".", ",")." Bs.";
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$i.':E'.$i)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("D".$i, "Total:")
	->setCellValue("E".$i, $total);
	//DATOS DE LA SALIDA DEL EXCEL
	$archivo="Listado De Beneficiarios desde ".$_POST['desde']." hasta ".$_POST['hasta'].".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>