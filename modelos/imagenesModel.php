<?php
require_once("../core/conex.php");
class imagenesModel extends Conex{
	private $rs;
	//--Metodo constructor...
	public function __construct(){
	}
	//--Verificar si existe la imagen
	public function existe_imagen($arreglo_datos){
		$sql = "SELECT
						count(*)
				FROM
						tbl_imagenes
				WHERE
						id='".$arreglo_datos["id_imagen"]."'";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;				
	}
	//--Registrar datos de imagen
	public function registrar_imagen($arreglo_datos){
		$sql = "INSERT INTO 
					tbl_imagenes
						(
							contenido,
							id_idioma
							)
				VALUES(
						'".$arreglo_datos["contenido"]."',
						'".$arreglo_datos["idioma"]."'
					);";
		$this->rs = $this->procesarQuery2($sql);
		//--Verifico que no sea error
		if($this->rs[0][0]!="error"){
		//--Consulto el id de la imagen
			$sql2 = "SELECT MAX(id) FROM tbl_imagenes";
			$rs2 = $this->procesarQuery($sql2);
		//--
			if($rs2!="error"){
				return $rs2[0][0];	 			
			}else{
				return 'error-2';
			}
		//--	
		}else{
				return 'error-1';
			}
		//--	
	}
	//---
	//--Metodo para modificar datos de imagen
	public function actualizar_imagen($arreglo_datos){
		$sql1 = "UPDATE tbl_imagenes SET contenido='".$arreglo_datos["contenido"]."' WHERE id='".$arreglo_datos["id_imagen"]."';";
		$this->rs = $this->procesarQuery2($sql1);
		if($this->rs==false){
			return "error-1";
		}else
		if($this->rs==true){
			return $this->rs;
		}	
	}
	//--
	public function ac_imagen_galeria($nombre_archivo,$id){
		$sql = "UPDATE
						tbl_imagenes
				SET
					archivo='".$nombre_archivo."'
				WHERE
					id='".$id."'";
		$this->rs = $this->procesarQuery2($sql);
		//return $sql;
		return $this->rs;			
	}
	//--
	public function consultar_imagenes_lista(){
		$sql="SELECT
					a.id as id,
					a.id_idioma,
					b.idioma,
					a.contenido,
					a.archivo,
					a.estatus
			  FROM
			  		tbl_imagenes a
			  INNER JOIN 
			  		tbl_idiomas b
			  ON
			  		a.id_idioma=b.id";
		$this->rs = $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;
	}
	//---
	public function consultar_estatus($id){
		$sql ="SELECT estatus FROM tbl_imagenes WHERE id ='".$id."'";
		$this->rs = $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;
	}
	//---
	public function activar_inactivar_imagen($id,$estatus){
		$sql = "UPDATE tbl_imagenes SET estatus='".$estatus."' WHERE id='".$id."';";
		$this->rs = $this->procesarQuery2($sql);
		//return $sql;
		return $this->rs;
	}
}
?>