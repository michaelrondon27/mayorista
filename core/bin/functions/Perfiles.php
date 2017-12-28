<?php
	function Perfiles(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM perfiles;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_perfil[$data['id_perfil']]=$data;
			}
		}else{
			$_perfil=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_perfil;
	}
?>