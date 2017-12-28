<?php
	if(isset($_SESSION['app_id']) AND $_users[$_SESSION['app_id']]['id_perfil']==1){
		$isset_id=isset($_GET['id']) AND is_numeric($_GET['id']) AND $_GET['id']>=1;
		require('core/models/classUser.php');
		$user=new User();
		switch (isset($_GET['mode']) ? $_GET['mode'] : null){
			case 'add':
				if($_POST){
					if(!empty($_POST['nombre']) && !empty($_POST['user']) && !empty($_POST['perfil']) && !empty($_POST['pass']) && !empty($_POST['repeat'])){
						$user->Add();
					}else{
						header("location: ?view=user&mode=add&error=2");
					}
				}else{
					include(HTML_DIR.'user/addUser.php');
				}
				break;
			case 'edit':
				if($isset_id AND array_key_exists($_GET['id'], $_users)){
					if($_POST){
						if(!empty($_POST['nombre']) && !empty($_POST['perfil']) && !empty($_POST['status'])){
							$user->Edit();
						}else{
							header("location: ?view=user&mode=edit&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'user/editUser.php');
					}
				}else{
					header('location: ?view=user');
				}
				break;
			case 'adminPass':
				if($isset_id AND array_key_exists($_GET['id'], $_users)){
					if($_POST){
						if(!empty($_POST['pass']) && !empty($_POST['repeat'])){
							if($_POST['pass']==$_POST['repeat']){
								$user->adminPass();
							}else{
								header("location: ?view=user&mode=edit&id=".$_GET['id']."&error=2");
							}
						}else{
							header("location: ?view=user&mode=edit&id=".$_GET['id']."&error=1");
						}
					}else{
						include(HTML_DIR.'user/AdminPass.php');
					}
				}else{
					header('location: ?view=user');
				}
				break;
			default:
				include(HTML_DIR.'user/allUser.php');
				break;
		}
	}else{
		header('location: ?view=index');
	}
?>