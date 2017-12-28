<?php
	function Status(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM status;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_status[$data['id_status']]=$data;
			}
		}else{
			$_status=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_status;
	}
?>