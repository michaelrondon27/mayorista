<?php
	Class Inventario{
		public function __construct(){
			$this->db=new Conexion();
		}
		
		public function __destruct(){
			$this->db->close();
		}
	}
?>