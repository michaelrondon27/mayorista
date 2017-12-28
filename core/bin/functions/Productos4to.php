<?php
	function Productos4to(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM productos_4to;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_producto4to[$data['id_producto']]=$data;
			}
		}else{
			$_producto4to=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_producto4to;
	}
?>