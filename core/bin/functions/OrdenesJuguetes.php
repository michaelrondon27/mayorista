<?php
	function OrdenesJuguetes(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM ordenes_juguetes;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_ordenesJuguetes[$data['id_cotizacion']]=$data;
			}
		}else{
			$_ordenesJuguetes=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_ordenesJuguetes;
	}
?>