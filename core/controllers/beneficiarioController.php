<?php
	if(isset($_SESSION['app_id'])){
		$isset_id=isset($_GET['id']) AND is_numeric($_GET['id']) AND $_GET['id']>=1;
		require('core/models/classBeneficiario.php');
		$beneficiario=new Beneficiario();
		switch (isset($_GET['mode']) ? $_GET['mode'] : null){
			case 'add':
				if($_POST){
					if(!empty($_POST['nombre']) && !empty($_POST['tipo']) && !empty($_POST['rif']) && !empty($_POST['cod_tlf']) && !empty($_POST['telefono']) && !empty($_POST['direccion']) && !empty($_POST['contacto'])){
						$usuario=$_users[$_SESSION['app_id']]['user'];
						$beneficiario->Add($usuario);
					}else{
						header("location: ?view=beneficiario&mode=add&error=2");
					}
				}else{
					include(HTML_DIR.'beneficiario/addBeneficiario.php');
				}
				break;
			case 'edit':
				if($isset_id AND array_key_exists($_GET['id'], $_beneficiario)){
					if($_POST){
						if(!empty($_POST['nombre']) && !empty($_POST['rif']) && !empty($_POST['cod_tlf']) && !empty($_POST['telefono']) && !empty($_POST['direccion']) && !empty($_POST['contacto'])){
							$usuario=$_users[$_SESSION['app_id']]['user'];
							$beneficiario->Edit($usuario);
						}else{
							header("location: ?view=beneficiario&mode=edit&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'beneficiario/editBeneficiario.php');
					}
				}else{
					header('location: ?view=beneficiario');
				}
				break;
			case 'excelBeneficiario':
				include(HTML_DIR.'beneficiario/excelBeneficiario.php');
				break;
			default:
				include(HTML_DIR.'beneficiario/allBeneficiario.php');
				break;
		}
	}else{
		header('location: ?view=index');
	}
?>