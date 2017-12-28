<?php
	function codTlf(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM cod_tlf;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_cod_tlf[$data['id_cod_tlf']]=$data;
			}
		}else{
			$_cod_tlf=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_cod_tlf;
	}
?>