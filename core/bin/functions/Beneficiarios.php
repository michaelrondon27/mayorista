<?php
	function Beneficiario(){
		$db=new Conexion();
		$sql=$db->query("SELECT * FROM empresa ORDER BY nombre;");
		if($db->rows($sql)>0){
			while($data=$db->recorrer($sql)){
				$_beneficiario[$data['id_empresa']]=$data;
			}
		}else{
			$_beneficiario=false;
		}
		$db->liberar($sql);
		$db->close();
		return $_beneficiario;
	}
?>