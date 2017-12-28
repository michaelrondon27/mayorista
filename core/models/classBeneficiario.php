<?php
	Class Beneficiario{
		private $db;
		private $nombre;
		private $tipo;
		private $rif;
		private $cod_tlf;
		private $telefono;
		private $cod_tlf2;
		private $telefono2;
		private $correo;
		private $direccion;
		private $contacto;
		private $id;
		private $usuario;
		public function __construct(){
			$this->db=new Conexion();
		}
		public function add($usuario){
			$this->nombre=$this->db->real_escape_string($_POST['nombre']);
			$this->nombre=trim(ucwords($this->nombre));
			$this->tipo=$this->db->real_escape_string($_POST['tipo']);
			$this->rif=$this->db->real_escape_string($_POST['rif']);
			$this->rif=$this->tipo."-".$this->rif;
			$this->cod_tlf=$this->db->real_escape_string($_POST['cod_tlf']);
			$this->telefono=$this->db->real_escape_string($_POST['telefono']);
			if(!empty($_POST['cod_tlf2']) && !empty($_POST['telefono2'])){
				$this->cod_tlf2=$this->db->real_escape_string($_POST['cod_tlf2']);
				$this->telefono2=$this->db->real_escape_string($_POST['telefono2']);
			}else{
				$this->cod_tlf2=0;
				$this->telefono2="";
			}
			if(!empty($_POST['correo'])){
				$this->correo=$this->db->real_escape_string($_POST['correo']);
				$this->correo=trim($this->correo);
			}else{
				$this->correo="";
			}			
			$this->direccion=$this->db->real_escape_string($_POST['direccion']);
			$this->direccion=trim($this->direccion);
			$this->contacto=$this->db->real_escape_string($_POST['contacto']);
			$this->contacto=trim(ucwords($this->contacto));
			$this->usuario=$usuario;
			$sql=$this->db->query("SELECT * FROM empresa WHERE nombre='$this->nombre' OR rif='$this->rif';");
			if($this->db->rows($sql)==0){
				$this->db->liberar($sql);
				$this->db->query("INSERT INTO empresa(nombre, rif, direccion, telefono, contacto, id_cod_tlf, id_status, telefono2, id_cod_tlf2, correo) VALUES('$this->nombre', '$this->rif', '$this->direccion', '$this->telefono', '$this->contacto', $this->cod_tlf, 1, '$this->telefono2', $this->cod_tlf2, '$this->correo');");
				$indicesServer = array('REMOTE_ADDR',);
				$ip=$_SERVER['REMOTE_ADDR'];
				$evento="Inserto al Beneficiario: ".$this->nombre." y  el rif: ".$this->rif;
				$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'INSERT');");
				header("location: ?view=beneficiario&mode=add&success=true");
			}else{
				$this->db->liberar($sql);
				header("location: ?view=beneficiario&mode=add&error=1");
			}
		}
		public function Edit($usuario){
			$this->id=intval($_GET['id']);
			$this->nombre=$this->db->real_escape_string($_POST['nombre']);
			$this->nombre=trim(ucwords($this->nombre));
			$this->tipo=$this->db->real_escape_string($_POST['tipo']);
			$this->rif=$this->db->real_escape_string($_POST['rif']);
			$this->rif=$this->rif;
			$this->cod_tlf=$this->db->real_escape_string($_POST['cod_tlf']);
			$this->telefono=$this->db->real_escape_string($_POST['telefono']);
			if(!empty($_POST['cod_tlf2']) && !empty($_POST['telefono2'])){
				$this->cod_tlf2=$this->db->real_escape_string($_POST['cod_tlf2']);
				$this->telefono2=$this->db->real_escape_string($_POST['telefono2']);
			}else{
				$this->cod_tlf2=0;
				$this->telefono2="";
			}
			if(!empty($_POST['correo'])){
				$this->correo=$this->db->real_escape_string($_POST['correo']);
				$this->correo=trim($this->correo);
			}else{
				$this->correo="";
			}			
			$this->direccion=$this->db->real_escape_string($_POST['direccion']);
			$this->direccion=trim($this->direccion);
			$this->contacto=$this->db->real_escape_string($_POST['contacto']);
			$this->contacto=trim(ucwords($this->contacto));
			$this->usuario=$usuario;
			$this->db->query("UPDATE empresa SET nombre='$this->nombre', rif='$this->rif', direccion='$this->direccion', telefono='$this->telefono', contacto='$this->contacto', id_cod_tlf=$this->cod_tlf, telefono2='$this->telefono2', id_cod_tlf2=$this->cod_tlf2, correo='$this->correo' WHERE id_empresa=$this->id LIMIT 1;");
			$indicesServer = array('REMOTE_ADDR',);
			$ip=$_SERVER['REMOTE_ADDR'];
			$evento="Actualizo al Beneficiario: ".$this->nombre." y  el rif: ".$this->rif;
			$this->db->query("INSERT INTO registro_eventos(ip, usuario, evento, fecha, operacion) VALUES('$ip', '$this->usuario', '$evento', NOW(), 'UPDATE');");
			header("location: ?view=beneficiario&mode=edit&id=".$this->id."&success=true");
		}
		public function __destruct(){
			$this->db->close();
		}
	}
?>