<?php
	if(isset($_SESSION['app_id'])){
		$isset_id=isset($_GET['id']) AND is_numeric($_GET['id']) AND $_GET['id']>=1;
		require('core/models/classUser.php');
		$user=new User();
		switch (isset($_GET['mode']) ? $_GET['mode'] : null){
			case 'change':
				if($_POST){
					if($_POST){
						if(!empty($_POST['pass']) && !empty($_POST['repeat'])){
							if($_POST['pass']==$_POST['repeat']){
								$user->changePass();
							}else{
								header("location: ?view=user&mode=change&error=2");
							}
						}else{
							header("location: ?view=user&mode=change&error=1");
						}
					}else{
						include(HTML_DIR.'user/changePass.php');
					}
				}else{
					include(HTML_DIR.'user/changePass.php');
				}
				break;
			default:
				header('location: ?view=index');
				break;
		}
	}else{
		header('location: ?view=index');
	}
?>