<?php
	function Ordenes3er(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM ordenes;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_ordenes3er[$data['id_cotizacion']]=$data;
			}
		}else{
			$_ordenes3er=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_ordenes3er;
	}
?>