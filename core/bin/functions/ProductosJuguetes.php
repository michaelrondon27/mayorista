<?php
	function ProductosJuguetes(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM productos_juguetes;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_productoJuguetes[$data['id_producto']]=$data;
			}
		}else{
			$_productoJuguetes=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_productoJuguetes;
	}
?>