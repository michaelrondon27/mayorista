<?php
	if(isset($_SESSION['app_id']) AND ($_users[$_SESSION['app_id']]['id_perfil']==1 || $_users[$_SESSION['app_id']]['id_perfil']==3 || $_users[$_SESSION['app_id']]['id_perfil']==4)){
		$isset_id=isset($_GET['id']) AND is_numeric($_GET['id']) AND $_GET['id']>=1;
		require('core/models/classInventario.php');
		$user=new User();
		switch (isset($_GET['mode']) ? $_GET['mode'] : null){
			case '3erCronograma':
				include(HTML_DIR.'inventario/all3erCronograma.php');
				break;
			case '4toCronogramaJuguetes':
				include(HTML_DIR.'inventario/all4toCronograma.php');
				break;
			case 'Juguetes':
				include(HTML_DIR.'inventario/allJuguetes.php');
				break;
			default:
				header('location: ?view=index');
				break;
		}
	}else{
		header('location: ?view=index');
	}
?>