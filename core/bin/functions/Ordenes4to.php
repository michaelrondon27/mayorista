<?php
	function Ordenes4to(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM ordenes_4to;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_ordenes4to[$data['id_cotizacion']]=$data;
			}
		}else{
			$_ordenes4to=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_ordenes4to;
	}
?>