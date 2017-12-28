<?php
	include("core/core.php");
	if(!empty($_POST['user']) AND !empty($_POST['pass'])){
		$db=new Conexion();
		$user=$db->real_escape_string($_POST['user']);
		$pass=Encrypt($_POST['pass']);
		$sql=$db->query("SELECT id_usuario FROM usuarios WHERE user='$user' AND password='$pass' LIMIT 1;");
		if($db->rows($sql)>0){
			$_SESSION['app_id']=$db->recorrer($sql)[0];
			$status=$_users[$_SESSION['app_id']]['id_status'];
			if($status==1){
				$usuario=$_users[$_SESSION['app_id']]['user'];
				$indicesServer = array('REMOTE_ADDR',);
				$ip=$_SERVER['REMOTE_ADDR'];
				$evento="Inicio de sesion del usuario: ".$usuario;
				$db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$usuario', '$evento', NOW(), 'LOGIN');");
				$db->liberar($sql);
				$db->close();
				header("location: ?view=index");
			}else{
				unset($_SESSION['app_id']);
				$db->liberar($sql);
				$db->close();
				header("location: index.php?error=3");
			}
		}else{
			$db->liberar($sql);
			$db->close();
			header("location: index.php?error=1");
		}		
	}else{
		header("location: index.php?error=2");
	}
?>