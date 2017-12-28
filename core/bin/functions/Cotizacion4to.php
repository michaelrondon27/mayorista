<?php
	function Cotizacion4to(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM cotizacion_4to;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_cotizacion4to[$data['id_cotizacion']]=$data;
			}
		}else{
			$_cotizacion4to=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_cotizacion4to;
	}
?>