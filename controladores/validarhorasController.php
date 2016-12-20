<?php
require_once("../modelos/horasextrasModel.php");
require_once("../vistas_logicas/validarhorasView.php");
//--Declaraciones
$mensajes = array();
$arreglo_datos = helper_userdata();
redireccionar_metodos($arreglo_datos);
//--
function redireccionar_metodos($arreglo_datos){
	switch ($arreglo_datos["accion"]) {
		case 'consultar_horas_extras_trabajadores':
			consultar_horas_extras_trabajadores();
			break;
		case 'consulta_detalle_horas_extras':
			consulta_detalle_horas_extras($arreglo_datos["id"]);
			break;
		case 'aprobar_registro':
			aprobar_registro($arreglo_datos["id"],$arreglo_datos["mes"],$arreglo_datos["unidad"]);
			break;
		case 'consultar_detalle_he':
			consultar_detalle_he($arreglo_datos["id"]);
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
		if ($user_data["accion"] == "consulta_detalle_horas_extras"){
			$user_data["id"] = $_POST["id"];
		}else if ($user_data["accion"] == "aprobar_registro"){
			$user_data["id"] = $_POST["id"];
			$user_data["mes"] = $_POST["mes"];
			$user_data["unidad"] = $_POST["unidad"];
		}else if ($user_data["accion"] == "consultar_detalle_he"){
			$user_data["id"] = $_POST["id"];
		}
		//--
	}
	return $user_data;
}

function consultar_horas_extras_trabajadores(){
	$recordset =  array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->consultar_horas_extras_aprobacion();
	if($recordset!="error"){
		render_vista_consulta_trabajadores("validar_lista_horas_trabajador",$recordset);
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
function aprobar_registro($id,$mes,$unidad){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset = $obj->aprobar_registro($id,$mes,$unidad);
	die(json_encode($recordset));	
}
//--
//Para cargar formulario de consulta de horas extras
function consultar_detalle_he($id){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new horasextrasModel();
	$recordset_encabezado = $obj->consultar_horas_extras_filtro($id);
	$recordset_detalle = $obj->consultar_horas_extras_detalle($id);
	if(($recordset_encabezado!="error")||($recordset_detalle!="error")){
		$html = render_vista_formulario_he("formulario_consulta_he",$recordset_encabezado);
		render_vista_dinamica_formulario_he($html,$recordset_detalle);
	}else{
		die(json_encode("error"));
	}
}
?>