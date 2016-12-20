<?php
require_once("../core/conex.php");
class usuarioModel extends Conex{
	private $rs;
	//--Metodo constructor...
	public function __construct(){
	}
	//--
	//Consultar idioma select
	public function consultar_select_tipous(){
		$sql = "SELECT 
						id,
						descripcion
				FROM
						tbl_tipo_usuarios";
		$this->rs = $this->procesarQuery($sql);
		//return $sql...
		return $this->rs;	
	}
	//--
	public function consultar_existe_us($arreglo_datos){
		$sql = "SELECT 
					count(*)
				FROM 
					tbl_usuarios
				WHERE
					login='".$arreglo_datos["login"]."';";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;			
	}
	//--
	public function consultar_existe_us2($arreglo_datos){
		$sql = "SELECT 
					count(*)
				FROM 
					tbl_usuarios
				WHERE
					login='".$arreglo_datos["login"]."'
				AND 
					id != '".$arreglo_datos["id_us"]."';";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;			
	}
	//--
	public function consultar_existe_us_id($arreglo_datos){
		$sql = "SELECT 
					count(*)
				FROM 
					tbl_usuarios
				WHERE
					id='".$arreglo_datos["id_us"]."';";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;			
	}
	//--
	public function guardar_us($arreglo_datos){
		$sql = "INSERT INTO 
							tbl_usuarios
				(
					login,
					id_tipo_usuario,
					password,
					estatus
				)
				VALUES
				(
					'".$arreglo_datos['login']."',
					'".$arreglo_datos['tipo_us']."',
					'".md5($arreglo_datos['pass'])."',
					'1'
				);";
		$this->rs = $this->procesarQuery2($sql);
		//return $sql;
		return $this->rs;
	}
	//--
	public function actualizar_us($arreglo_datos){
		$sql ="UPDATE 
					tbl_usuarios
				SET 
					login='".$arreglo_datos['login']."',
					id_tipo_usuario='".$arreglo_datos['tipo_us']."',
					password='".md5($arreglo_datos['pass'])."'
				WHERE
					id='".$arreglo_datos['id_us']."';";
		$this->rs = $this->procesarQuery2($sql);					
		//return $sql;
		return $this->rs;
	}
	//--
	public function consultar_usuarios_lista(){
		$sql="SELECT
					a.id as id,
					a.login,
					a.id_tipo_usuario,
					b.descripcion,
					a.estatus,
					c.descripcion
			  FROM
			  		tbl_usuarios a 
			  INNER JOIN 
			  		tbl_tipo_usuarios b
			  ON 
			  		b.id=a.id_tipo_usuario
			  INNER JOIN
			  		tbl_estatus c
			  ON 
			  		c.id=a.estatus		 ;";
		$this->rs = $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;
	}
	//--
	public function activar_inactivar_us($id,$estatus){
		$sql = "UPDATE tbl_usuarios SET estatus='".$estatus."' WHERE id='".$id."';";
		$this->rs = $this->procesarQuery2($sql);
		//return $sql;
		return $this->rs;
	}	
	//--
	public function consultar_estatus($id){
		$sql ="SELECT estatus FROM tbl_usuarios WHERE id ='".$id."'";
		$this->rs = $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;
	}
	//--
	public function consultar_pantallas_lista(){
		$sql = "SELECT 
						id, 
						pantallas 
				FROM 
					tbl_pantallas 
				WHERE 
					estatus='1'";
		$this->rs= $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;			
	}
	//--
	public function consultar_existe_us_permiso($arreglo_datos){
		$sql = "SELECT 
					count(*)
				FROM 
					tbl_permisos
				WHERE
					id_usuario='".$arreglo_datos["usuarios"]."'
				AND
					id_pantalla='".$arreglo_datos["pantallas"]."';";
		$this->rs = $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;			
	}
	//--
	public function existe_us_permiso_id($arreglo_datos){
		$sql = "SELECT 
					count(*)
				FROM 
					tbl_permisos
				WHERE
					id='".$arreglo_datos["id_us_permiso"]."';";
		$this->rs = $this->procesarQuery2($sql);
		return $this->rs;
	}
	//--
	public function guardar_us_permiso($arreglo_datos){
		$sql = "INSERT INTO
					tbl_permisos
					(id_usuario,id_pantalla,estatus)
				VALUES
					('".$arreglo_datos["usuarios"]."','".$arreglo_datos["pantallas"]."','1');";
		$this->rs = $this->procesarQuery2($sql);
		//return $sql;
		return $this->rs;			
	}
	//--	
	public function actualizar_us_permiso($arreglo_datos){
		$sql = "UPDATE
					tbl_permisos
				SET	
					estatus = '".$arreglo_datos["estatus"]."'
				WHERE 
					id_usuario = '".$arreglo_datos["usuarios"]."'
				AND	
					id_pantalla = '".$arreglo_datos["pantallas"]."';";
		$this->rs = $this->procesarQuery2($sql);
		return $this->rs;			
	}
	//--
	public function consultar_faov(){
		$id_persona = $_SESSION['id_persona'];
		$sql = "SELECT 
						a.nombres,
						a.apellidos,
						a.cedula,
						a.fecha_nac,
						b.cargo,
						b.fecha_ingreso,
						b.n_afiliacion,
						b.oficina
				FROM 
						tbl_personas a
				INNER JOIN 
						tbl_persona_fao	b
				ON 
						a.id = b.id_persona_fao
				WHERE 
						a.id ='".$id_persona."'";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;
	}
	//--
}
?>