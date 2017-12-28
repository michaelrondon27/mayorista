<?php
	require("views/app/libs/PHPExcel/PHPExcel.php");
	$db=new Conexion();
	//VARIABLES DE PHP
	$objPHPExcel=new PHPExcel();
	//DATOS DE LA CONEXION
	$id_cotizacion=$_GET['id'];
	$indicesServer = array('REMOTE_ADDR',);
	$ip=$_SERVER['REMOTE_ADDR'];
	$evento="Reporte de la cotizacion del 4to cornograma en excel: ".$id_cotizacion;
	$usuario=$_users[$_SESSION['app_id']]['user'];
	$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'REPORTE');");
	//PROPIEDADES DE ARCHIVO EXCEL
	$objPHPExcel->getProperties()->setCreator("Cotizacion")
	->setLastModifiedBy("Cotizacion")
	->setTitle("Reporte XLS")
	->setSubject("Reporte")
	->setDescription("")
	->setKeywords("")
	->setCategory("");
	//PROPIEDADES DE LA CELDA
	$objPHPExcel->getDefaultStyle()->getFont()->setSize('12');
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	//CABECERA DE LA CONSULTA
	$i=1;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$i, "ALMACENADORA")
	->setCellValue("B".$i, "PRODUCTO")
	->setCellValue("C".$i, "MODELO")
	->setCellValue("D".$i, "CANTIDAD");
	$objPHPExcel->getActiveSheet()
				->getStyle('A1:D1')
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
				->getStyle('A1:D1')
				->applyFromArray($borders);
	//DETALLE DE LA CONSULTA
	$sql=$db->query("SELECT o.cantidad, p.producto, m.modelo, a.nombre FROM ordenes_4to o INNER JOIN productos_4to p ON o.id_producto=p.id_producto INNER JOIN modelo_4to m ON o.id_modelo=m.id_modelo INNER JOIN almacenadoras_4to a ON o.id_almacenadora=a.id_almacenadora WHERE o.id_cotizacion=$id_cotizacion;");
	while($data=$db->recorrer($sql)){
		$i++;
		//BORDE DE LA CELDA
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A'.$i.':D'.$i)
		->applyFromArray($borders);
		//MOSTRAMOS LOS VALORES
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$i, $data[3])
		->setCellValue("B".$i, $data[1])
		->setCellValue("C".$i, $data[2])
		->setCellValue("D".$i, $data[0]);
	}
	//DATOS DE LA SALIDA DEL EXCEL
	$archivo="Listado De Productos de la Cotizacion ".$_cotizacion4to[$id_cotizacion]['cotizacion'].".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>