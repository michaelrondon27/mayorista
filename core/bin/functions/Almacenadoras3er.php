<?php
	function Almacenadoras3er(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM almacenadoras;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_almacenadora3er[$data['id_almacenadora']]=$data;
			}
		}else{
			$_almacenadora3er=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_almacenadora3er;
	}
?>