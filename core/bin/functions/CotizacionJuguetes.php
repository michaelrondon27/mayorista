<?php
	function CotizacionJuguetes(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM cotizacion_juguetes;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_cotizacionJuguetes[$data['id_cotizacion']]=$data;
			}
		}else{
			$_cotizacionJuguetes=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_cotizacionJuguetes;
	}
?>