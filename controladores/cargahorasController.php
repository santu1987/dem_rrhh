<?php
require_once("../modelos/horasextrasModel.php");
require_once("../vistas_logicas/cargahorasView.php");
//--Declaraciones
$mensajes = array();
$arreglo_datos = helper_userdata();
redireccionar_metodos($arreglo_datos);
//--
function redireccionar_metodos($arreglo_datos){
	switch ($arreglo_datos["accion"]) {
		case 'listar_filas_he':
			lista_filas($arreglo_datos);
			break;
		case 'consultar_trabajador':
			consultar_informacion_trabajador($arreglo_datos);
			break;
		case 'guardar_horas_extras':
			guardar_horas_extras($arreglo_datos);
			break;	
		case 'consultar_horas_extras_trabajadores':
			consultar_horas_extras_trabajadores();
			break;
		case 'consulta_detalle_horas_extras':
			consulta_detalle_horas_extras($arreglo_datos["id"]);
			break;
		case 'anular_registro':
			anular_registro($arreglo_datos["id"],$arreglo_datos["mes"]);
			break;
		case 'consultar_dias_extras_trabajadores':
			consultar_dias_extras_trabajadores($arreglo_datos["unidad"]);
			break;
		case 'consultar_select_dptos':
			consultar_select_dptos();
			break;		 							
	}	
}
//---
function helper_userdata(){
	$user_data = array();
	if($_POST){
		//--
		if(array_key_exists('accion', $_POST)){
			$user_data["accion"] = $_POST["accion"];
		}
		if ($user_data["accion"]  == "listar_filas_he"){
		//--Para campos recibidos que van a lista_filas
			if(array_key_exists('valore', $_POST)){
				$user_data["valore"] = $_POST["valore"];
			}	
		}else if ($user_data["accion"]  == "consultar_trabajador"){
		//--Para campos recibidos que va a consulta trabajador	
			$user_data["cedula"] = $_POST["cedula"];
		}else if($user_data["accion"] == "guardar_horas_extras"){
			$user_data["id_trabajador"] = $_POST["id_trabajador"];
			$user_data["motivo"] = $_POST["motivo"];
			$user_data["mes"] = $_POST["mes"];
			$user_data["horas_totales"] = $_POST["horas_totales"];
			$user_data["estatus"] = $_POST["estatus"]; 
			$user_data["tipo_hora"] = $_POST["tipo_hora"];
			$user_data["vector"] = $_POST["vector"];
			$user_data["id_he"] = $_POST["id_he"];
		}else if ($user_data["accion"] == "consulta_detalle_horas_extras"){
			$user_data["id"] = $_POST["id"];
		}else if ($user_data["accion"] == "anular_registro"){
			$user_data["id"] = $_POST["id"];
			$user_data["mes"] = $_POST["mes"];
		}else if($user_data["accion"] == "consultar_dias_extras_trabajadores"){
			$user_data["unidad"] = $_POST["unidad"];
		} 

		//--
	}
	return $user_data;
}
//---
function lista_filas($arreglo_datos){
	render_vista_consulta("lista_horas_extras",$arreglo_datos);
}
//---
function consultar_informacion_trabajador($arreglo_datos){
	$recordset = array();
	$obj = new horasextrasModel();
	$recordset = $obj -> consulta_datos_trabajador($arreglo_datos);
	if(!$recordset){
		$recordset[0] = "error";
	}
	die(json_encode($recordset));
}
//--
function guardar_horas_extras($arreglo_datos){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->registrar_horas_extras($arreglo_datos);
	$arreglo_valor = explode("*",$recordset[0][0]);
	die(json_encode($arreglo_valor));
}
//--
function consultar_horas_extras_trabajadores(){
	$recordset =  array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->consultar_horas_extras();
	//die(json_encode($recordset));
	if($recordset!="error"){
		render_vista_consulta_trabajadores("lista_horas_trabajador",$recordset);
	}else{
		$recordset="error";
		die($recordset);
	}
}
//--
function consulta_detalle_horas_extras($id){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->consultar_horas_extras_detalle($id);
	//die(json_encode($recordset));
	if($recordset!="error"){
		render_vista_consulta_lista_horas_extras("consulta_listas_horas_trabajador",$recordset);
	}else{
		$recordset = "error";
		die($recordset);
	}
}
//--
function anular_registro($id,$mes){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->anular_registro($id,$mes);
	die(json_encode($recordset));	
}
//--
//--Dias extras
function consultar_dias_extras_trabajadores($unidad){
	$recordset =  array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->consultar_dias_extras($unidad);
	if($recordset!="error"){
		render_vista_consulta_trabajadores("lista_horas_trabajador",$recordset);
	}else{
		$recordset="error";
		die($recordset);
	}
}
//--Select de departamentos
function consultar_select_dptos(){
	$recordset = array();
	$arreglo_valor = array();
	$objeto = new horasextrasModel();
	$recordset = $objeto->consultar_departamentos();
	if($recordset!="error"){
		render_vista_consulta_departamentos("select_departamentos",$recordset);
	}else{
		$recordset =  "error";
		die($recordset);
	}
}
?>