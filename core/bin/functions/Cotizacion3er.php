<?php
	function Cotizacion3er(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM cotizacion;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_cotizacion3er[$data['id_cotizacion']]=$data;
			}
		}else{
			$_cotizacion3er=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_cotizacion3er;
	}
?>