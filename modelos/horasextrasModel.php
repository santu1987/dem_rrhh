<?php
require_once("../core/conex.php");
class horasextrasModel extends Conex{
	private $rs;
	//--Metodo constructor...
	public function __construct(){
	}
	//Consulta los datos de usuario segun cedula
	//--
	public function consulta_datos_trabajador($arreglo_datos){
		$unidad_administrativa = $_SESSION['id_unidad_Administrativa'];
		$sql = "SELECT 
						a.nombres,
						a.apellidos,
						b.cargo,
						b.id,
						b.id_unidad_administrativa
				FROM 
						tbl_personas a
				INNER JOIN 
						tbl_trabajador b
				ON 
						a.id=b.id_persona
				WHERE 
						a.cedula='".$arreglo_datos["cedula"]."'
				AND 
						b.id_unidad_administrativa='".$unidad_administrativa."';";

		$this->rs = $this->procesarQuery($sql);
		//return $sql;
		return $this->rs;				
	}
	//Guarda los valores en base de datos...
	public function registrar_horas_extras($arreglo_datos){
		if($arreglo_datos["id_he"]==""){ //guardo
			$super_arreglo = to_pg_array($arreglo_datos["vector"]);
			$sql = "select registrar_horas_extras('".$arreglo_datos["id_trabajador"]."',
												  '".$arreglo_datos["mes"]."',
												  '".$arreglo_datos["horas_totales"]."',
												  '".$arreglo_datos["estatus"]."',
												  '".$arreglo_datos["tipo_hora"]."',
												  '".$super_arreglo."')";
			$this->rs = $this->procesarQuery($sql);
			return $this->rs;
		}elseif ($arreglo_datos["id_he"]!="") { //modifico
			$super_arreglo = to_pg_array($arreglo_datos["vector"]);
			$sql = "select modificar_horas_extras('".$arreglo_datos["id_he"]."',
												  '".$arreglo_datos["id_trabajador"]."',
												  '".$arreglo_datos["mes"]."',
												  '".$arreglo_datos["horas_totales"]."',
												  '".$arreglo_datos["estatus"]."',
												  '".$arreglo_datos["tipo_hora"]."',
												  '".$super_arreglo."')";
			$this->rs = $this->procesarQuery($sql);
			return $this->rs;
			//return $sql;									  
		}	
	}
	//Consulta las horas extras creadas hasta el momento
	public function consultar_horas_extras(){
		$sql="SELECT 
				a.id as id_horas_extras_enc,
				a.id_trabajador,
				c.nombres||' '||c.apellidos as nombres,
				c.cedula as cedula,
				b.cargo,
				a.mes,
				a.motivo, 
				a.total, 
				a.estatus,
				d.descripcion,
				a.id_tipo_hora,
				e.descripcion,
				a.anio,
				b.id_unidad_administrativa
			  FROM 
				tbl_horas_extras_enc a
			  INNER JOIN
				tbl_trabajador b
			  ON 
				a.id_trabajador = b.id
			  INNER JOIN
				tbl_personas c
			  ON 
			  	b.id_persona = c.id
			  INNER JOIN 
				tbl_estatus d
			  ON
				d.id=a.estatus
			  INNER JOIN
				tbl_tipo_hora e
			  ON 
				e.id=a.id_tipo_hora	
			  WHERE
				c.id_estatus=1
			  AND 
			  	a.id_tipo_hora!=3
			  AND 
				a.estatus!=3	
			  AND 
			  	b.id_unidad_administrativa = '".$_SESSION["id_unidad_Administrativa"]."'		
			  ORDER BY 
			  	a.mes DESC, 
			  	a.anio,
			  	a.estatus ;";
		$this->rs = $this->procesarQuery($sql);	
		return $this->rs;	
	}
	//Consulta las horas extras filtrada por id...
	public function consultar_horas_extras_filtro($id){
		$sql="SELECT 
				a.id as id_horas_extras_enc,
				a.id_trabajador,
				c.nombres||' '||c.apellidos as nombres,
				c.cedula as cedula,
				b.cargo,
				a.mes,
				a.motivo, 
				a.total, 
				a.estatus,
				d.descripcion,
				a.id_tipo_hora,
				e.descripcion,
				a.anio,
				b.id_unidad_administrativa
			  FROM 
				tbl_horas_extras_enc a
			  INNER JOIN
				tbl_trabajador b
			  ON 
				a.id_trabajador = b.id
			  INNER JOIN
				tbl_personas c
			  ON 
			  	b.id_persona = c.id
			  INNER JOIN 
				tbl_estatus d
			  ON
				d.id=a.estatus
			  INNER JOIN
				tbl_tipo_hora e
			  ON 
				e.id=a.id_tipo_hora	
			  WHERE
				c.id_estatus=1
			  AND 
			  	a.id = '".$id."'	
			  ORDER BY 
			  	a.mes DESC, 
			  	a.anio,
			  	a.estatus ;";
		$this->rs = $this->procesarQuery($sql);	
		return $this->rs;	
	}
	//Metodo que consulta el detalle de las horas extras
	public function consultar_horas_extras_detalle($id){
		$sql = "SELECT 
					a.id,
					a.id_horas_extra_enc,
					a.fecha,
					a.hora_inicio,
					a.hora_fin,
					a.cant_horas,
					a.motivo
				FROM 
					tbl_horas_extras_detalle a
				WHERE 
						a.id_horas_extra_enc='".$id."'
				AND 
						a.estatus='1'";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;
	}
	//Metodo que anula un registro de horas extras
	public function anular_registro($id,$mes){
		$sql="SELECT anular_registro('".$id."','".$mes."')";
		$this->rs =$this->procesarQuery($sql);
		return $this->rs;
	}
	//Metodo que consulta las horas extras activas
	public function consultar_horas_extras_aprobacion(){
		$sql="SELECT 
				a.id as id_horas_extras_enc,
				a.id_trabajador,
				c.nombres||' '||c.apellidos as nombres,
				c.cedula as cedula,
				b.cargo,
				a.mes,
				a.motivo, 
				a.total, 
				a.estatus,
				d.descripcion,
				a.id_tipo_hora,
				e.descripcion,
				a.anio,
				f.descripcion as unidad_administrativa,
				b.id_unidad_administrativa
			  FROM 
				tbl_horas_extras_enc a
			  INNER JOIN
				tbl_trabajador b
			  ON 
				a.id_trabajador = b.id
			  INNER JOIN
				tbl_personas c
			  ON 
			  	b.id_persona = c.id
			  INNER JOIN 
				tbl_estatus d
			  ON
				d.id=a.estatus
			  INNER JOIN
				tbl_tipo_hora e
			  ON 
				e.id=a.id_tipo_hora
			  INNER JOIN 
				tbl_unidad_administrativa f
			  ON 
				f.id = b.id_unidad_administrativa			
			  WHERE
				c.id_estatus!=3
			  AND 
			    a.estatus!=2	
			  AND 
			  	a.estatus!=3  
			  ORDER BY 
			  	a.id_trabajador,
				a.mes DESC, 
			  	a.anio,
			  	e.descripcion,
			  	a.estatus;";
		$this->rs = $this->procesarQuery($sql);	
		return $this->rs;
	}
	//Metodo que anula un registro de horas extras
	public function aprobar_registro($id,$mes,$unidad){
		$sql="SELECT aprobar_registro('".$id."','".$mes."','".$unidad."')";
		$this->rs =$this->procesarQuery($sql);
		return $this->rs;
	}
	//Metodo que alimenta la primera parte del reporte
	public function consultar_datos_trabajador_reporte($id){
		$sql = "SELECT
					a.nombres||' '||apellidos AS nombres_apellidos,
					a.cedula,
					c.descripcion tipo_personal,
					b.cargo,
					b.condicion,
					d.total,
					e.descripcion as unidad_administrativa,
					d.motivo,
					d.id,
					d.mes,
					f.descripcion
				  FROM 
					tbl_personas a
				  INNER JOIN 	
					tbl_trabajador b
				 ON
					a.id = b.id_persona
				 INNER JOIN 
					tbl_tipo_personal c
				 ON 
					c.id = b.id_tipo_personal
				INNER JOIN 
					tbl_horas_extras_enc d
				ON 
					d.id_trabajador = b.id
				INNER JOIN 
					tbl_unidad_administrativa 	e
				ON 
					e.id = b.id_unidad_administrativa
				INNER JOIN
					tbl_tipo_hora f
				ON 
					f.id = d.id_tipo_hora
				WHERE
					d.id='".$id."';";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;
	}
	//--
	public function consultar_dias_extras($unidad){
		$sql="SELECT 
				a.id as id_horas_extras_enc,
				a.id_trabajador,
				c.nombres||' '||c.apellidos as nombres,
				c.cedula as cedula,
				b.cargo,
				a.mes,
				a.motivo, 
				a.total, 
				a.estatus,
				d.descripcion,
				a.id_tipo_hora,
				e.descripcion,
				a.anio
			  FROM 
				tbl_horas_extras_enc a
			  INNER JOIN
				tbl_trabajador b
			  ON 
				a.id_trabajador = b.id
			  INNER JOIN
				tbl_personas c
			  ON 
			  	b.id_persona = c.id
			  INNER JOIN 
				tbl_estatus d
			  ON
				d.id=a.estatus
			  INNER JOIN
				tbl_tipo_hora e
			  ON 
				e.id=a.id_tipo_hora	
			  WHERE
				c.id_estatus=1
			  AND 
			  	a.id_tipo_hora = 3
			  AND
			  	b.id_unidad_administrativa = '".$unidad."'		
			  ORDER BY 
			  	a.mes DESC, 
			  	a.anio,
			  	a.estatus ;";
		$this->rs = $this->procesarQuery($sql);	
		return $this->rs;	
	}
	//--
	public function consultar_departamentos(){
		$sql = "SELECT id, descripcion, codigo FROM tbl_unidad_administrativa";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;
	}
	//--
	public function consultar_datos_detalle_horas_extras($fecha_desde,$fecha_hasta,$unidad_administrativa){
		$where = "WHERE 1=1 ";
		if($fecha_desde!=""){
			$where.=" AND d.fecha >= '".$fecha_desde."'"; 
		}
		if($fecha_hasta!=""){
			$where.=" AND d.fecha <= '".$fecha_hasta."'"; 
		}
		if($unidad_administrativa!=""){
			$where.=" AND c.id = '".$unidad_administrativa."'"; 
		}
		$sql = "SELECT 
						a.nombres||' '||a.apellidos,
						a.cedula,
						b.cargo,
						c.descripcion AS unidad_administrativa,
						d.fecha,
						d.hora_inicio,
						d.hora_fin,
						d.cant_horas
				FROM 
						tbl_horas_extras_enc e
				INNER JOIN 
						tbl_trabajador b
				ON 
						b.id = e.id_trabajador
				INNER JOIN 
						tbl_personas a 
				ON 
						a.id = b.id_persona
				INNER JOIN 
						tbl_unidad_administrativa c
				ON 
						c.id = b.id_unidad_administrativa
				INNER JOIN 
						tbl_horas_extras_detalle d 
				ON 
						d.id_horas_extra_enc = e.id
				AND 
						d.estatus=1
				".$where."		
				ORDER BY
						d.fecha";
		$this->rs = $this->procesarQuery($sql);
		return $this->rs;
	}
	//--
}	