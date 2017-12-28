<?php
	function DespachoJuguetes(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM despacho_juguetes;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_despachoJuguetes[$data['id_cotizacion']]=$data;
			}
		}else{
			$_despachoJuguetes=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_despachoJuguetes;
	}
?>