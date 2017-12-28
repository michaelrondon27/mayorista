<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'mayorista');
	require('../models/classConexion.php');
	require('../models/classBuscar.php');
	$buscar=new Buscar();
	$valor=$_POST['valor'];
	switch ($valor) {
		case 1:
			$buscar->modelo3er();
			break;
		case 2:
			$buscar->precio3er();
			break;
		case 3:
			$buscar->modelo4to();
			break;
		case 4:
			$buscar->precio4to();
			break;
		case 5:
			$buscar->precioJuguetes();
			break;
	}
?>