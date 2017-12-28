<?php
	function Despacho4to(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM despacho_4to;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_despacho4to[$data['id_cotizacion']]=$data;
			}
		}else{
			$_despacho4to=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_despacho4to;
	}
?>