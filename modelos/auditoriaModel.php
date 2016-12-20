<?php
require_once("../core/conex.php");
class auditoriaModel extends Conex{
	//--
	public function guardar_auditoria($id_usuario,$ip,$proceso_ejecutado,$tabla_afectada,$id,$descripcion){
		$sql ="INSERT INTO 
							tbl_auditoria
			 			(
			 				id_usuario,
			 				ip,
			 				fecha_hora,
			 				proceso_ejecutado,
			 				tabla_afectada,
			 				id_campo_tabla,
			 				descripcion_proceso)
			   			VALUES (
			 				'".$id_usuario."',
			 				'".$ip."',
			 				'".date('Y-m-d H:i:s')."',
			 				'".$proceso_ejecutado."',
			 				'".$tabla_afectada."',
			 				'".$id."',
			 				'".$descripcion."'
			 			);";			
		$this->rs = $this->procesarQuery2($sql);
		return $this->rs;	 
	//--
	}
}	
?>	