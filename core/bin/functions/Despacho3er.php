<?php
	function Despacho3er(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM despacho;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_despacho3er[$data['id_cotizacion']]=$data;
			}
		}else{
			$_despacho3er=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_despacho3er;
	}
?>