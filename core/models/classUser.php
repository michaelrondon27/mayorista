<?php
	Class User{
		private $db;
		private $user;
		private $nombre;
		private $perfil;
		private $pass;
		private $repeat;
		private $status;
		private $id;
		public function __construct(){
			$this->db=new Conexion();
		}
		public function add(){
			$this->pass=Encrypt($_POST['pass']);
			$this->repeat=Encrypt($_POST['repeat']);
			if($this->pass==$this->repeat){
				$this->user=$this->db->real_escape_string($_POST['user']);
				$this->user=trim($this->user);
				$this->nombre=$this->db->real_escape_string($_POST['nombre']);
				$this->nombre=trim(ucwords($this->nombre));
				$this->perfil=$this->db->real_escape_string($_POST['perfil']);
				$sql=$this->db->query("SELECT * FROM usuarios WHERE user='$this->user';");
				if($this->db->rows($sql)==0){
					$this->db->query("INSERT INTO usuarios(user, nombre, password, id_status, id_perfil) VALUES('$this->user', '$this->nombre', '$this->pass', 1, $this->perfil);");
					header("location: ?view=user&mode=add&success=true");
				}else{
					$this->db->liberar($sql);
					header("location: ?view=user&mode=add&error=3");
				}
			}else{
				header("location: ?view=user&mode=add&error=1");
			}
		}
		public function Edit(){
			$this->id=intval($_GET['id']);
			$this->nombre=$this->db->real_escape_string($_POST['nombre']);
			$this->nombre=trim(ucwords($this->nombre));
			$this->perfil=$this->db->real_escape_string($_POST['perfil']);
			$this->status=$this->db->real_escape_string($_POST['status']);
			$this->db->query("UPDATE usuarios SET nombre='$this->nombre', id_status='$this->status', id_perfil='$this->perfil' WHERE id_usuario=$this->id LIMIT 1;");
			header("location: ?view=user&mode=edit&id=".$this->id."&success=true");
		}
		public function adminPass(){
			$this->id=intval($_GET['id']);
			$this->pass=Encrypt($_POST['pass']);
			$this->db->query("UPDATE usuarios SET password='$this->pass' WHERE id_usuario=$this->id LIMIT 1;");
			header("location: ?view=user&mode=adminPass&id=".$this->id."&success=true");
		}
		public function changePass(){
			$this->id=intval($_GET['id']);
			$this->pass=Encrypt($_POST['pass']);
			$this->db->query("UPDATE usuarios SET password='$this->pass' WHERE id_usuario=$this->id LIMIT 1;");
			header("location: ?view=pass&mode=change&success=true");
		}
		public function __destruct(){
			$this->db->close();
		}
	}
?>