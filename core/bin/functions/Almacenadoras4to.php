<?php
	function Almacenadoras4to(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM almacenadoras_4to;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_almacenadora4to[$data['id_almacenadora']]=$data;
			}
		}else{
			$_almacenadora4to=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_almacenadora4to;
	}
?>