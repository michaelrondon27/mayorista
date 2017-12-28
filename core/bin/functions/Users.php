<?php
	function Users(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM usuarios;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$users[$data['id_usuario']]=$data;
			}
		}else{
			$users=$_SESSION['users'];
		}
		$_SESSION['users']=$users;
		$db->liberar($sql);
		$db->close();
		return $_SESSION['users'];
	}
?>