<?php
	//EL NUCLEO DE LA APLICACION
	session_start();
	#CONSTATNTES DE CONEXTION
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'mayorista');
	#CONSTANTES DE LA APP
	define('HTML_DIR','html/');
	define('APP_TITLE','COMERSSO');
	define('APP_COPY', 'Copyright &copy; '.date('Y',time()).' Desarrollado por Michael Rondón & Brandon Velasquez, COMERSSO.');
	define('APP_URL','http://192.168.9.25/mayorista/');
	define('LOGO','views/app/images/Logo comersso.png');
	define('ICON','views/app/images/Logo comersso.png');

	#CONEXION
	require('core/models/classConexion.php');
	#GLOBALES
	require('core/bin/functions/Encrypt.php');
	require('core/bin/functions/Perfiles.php');
	require('core/bin/functions/Users.php');
	require('core/bin/functions/Status.php');
	require('core/bin/functions/Beneficiarios.php');
	require('core/bin/functions/codTlf.php');
	$_perfil=Perfiles();
	$_users=Users();
	$_status=Status();
	$_beneficiario=Beneficiario();
	$_cod_tlf=codTlf();

	#3ER CORNOGRAMA
	require('core/bin/functions/Cotizacion3er.php');
	require('core/bin/functions/Ordenes3er.php');
	require('core/bin/functions/Despacho3er.php');
	require('core/bin/functions/Almacenadoras3er.php');
	require('core/bin/functions/Productos3er.php');
	require('core/bin/functions/Inventario3er.php');
	$_cotizacion3er=Cotizacion3er();
	$_ordenes3er=Ordenes3er();
	$_despacho3er=Despacho3er();
	$_almacenadoras3er=Almacenadoras3er();
	$_producto3er=Productos3er();
	$_inventario3er=Inventario3er();
	
	#4TO CORNOGRAMA
	require('core/bin/functions/Cotizacion4to.php');
	require('core/bin/functions/Ordenes4to.php');
	require('core/bin/functions/Despacho4to.php');
	require('core/bin/functions/Almacenadoras4to.php');
	require('core/bin/functions/Productos4to.php');
	$_cotizacion4to=Cotizacion4to();
	$_ordenes4to=Ordenes4to();
	$_despacho4to=Despacho4to();
	$_almacenadoras4to=Almacenadoras4to();
	$_producto4to=Productos4to();

	#JUGUETES
	require('core/bin/functions/CotizacionJuguetes.php');
	require('core/bin/functions/OrdenesJuguetes.php');
	require('core/bin/functions/DespachoJuguetes.php');
	require('core/bin/functions/AlmacenadorasJuguetes.php');
	require('core/bin/functions/ProductosJuguetes.php');
	#JUGUETES
	$_cotizacionJuguetes=CotizacionJuguetes();
	$_ordenesJuguetes=OrdenesJuguetes();
	$_despachoJuguetes=DespachoJuguetes();
	$_almacenadorasJuguetes=AlmacenadorasJuguetes();
	$_productoJuguetes=ProductosJuguetes();
?>