<?php
require_once("../core/conex.php");
class inicioModel extends Conex{
	private $rs;
	//--Metodo constructor...
	public function __construct(){
	}
	//--
	public function inicio_session($arreglo_datos){
		$sql = "SELECT 
					count(*)
				FROM 
					tbl_usuarios
				WHERE
					login='".$arreglo_datos['usuario']."'
				AND 
					password=md5('".$arreglo_datos['password']."')
				AND 
					estatus=1";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;
	}
	//--
	public function obtener_datos_us($login){
		$sql = "SELECT 
					a.id,
					a.login,
					b.descripcion,
					a.id_persona,
					c.id_unidad_administrativa,
					d.nombres||' '||d.apellidos
				FROM 
					tbl_usuarios a
				INNER JOIN 
					tbl_tipo_usuarios b
				ON 
					a.id_tipo_usuario=b.id
				INNER JOIN 
					tbl_trabajador c
				ON 
					a.id_persona = c.id_persona
				INNER JOIN
					tbl_personas d
				ON 
					d.id = a.id_persona					
				WHERE
					a.login='".$login."';";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;	
	}
	//--
	public function ver_permisos($id){
		$sql="SELECT 
					a.login,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='1') as empresa,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='2') as nosotros_nuestra_empresa,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='3') as nosotros_mision,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='4') as nosotros_vision,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='5') as nosotros_historia,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='6') as nosotros_productos,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='7') as nosotros_redes_sociales,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='8') as curriculum,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='9') as noticias,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='10') as galerias_imagen,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='11') as galerias_videos,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='12') as contactos,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='13') as usuarios,
					(select b.estatus from tbl_permisos b where id_usuario = a.id and id_pantalla='14') as usuarios_permisos
				FROM 
					tbl_usuarios a
				WHERE id = '".$id."';";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;	
	}
}	
?>