<?php
	function Inventario3er(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM existencia;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_inventario3er[$data['id_existencia']]=$data;
			}
		}else{
			$_inventario3er=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_inventario3er;
	}
?>