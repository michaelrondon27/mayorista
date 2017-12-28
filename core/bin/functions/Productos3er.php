<?php
	function Productos3er(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM productos;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_producto3er[$data['id_producto']]=$data;
			}
		}else{
			$_producto3er=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_producto3er;
	}
?>