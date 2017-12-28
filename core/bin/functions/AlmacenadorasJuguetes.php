<?php
	function AlmacenadorasJuguetes(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM almacenadoras_juguetes;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_almacenadoraJuguetes[$data['id_almacenadora']]=$data;
			}
		}else{
			$_almacenadoraJuguetes=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_almacenadoraJuguetes;
	}
?>