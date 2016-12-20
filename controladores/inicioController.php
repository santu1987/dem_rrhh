<?php
require_once("../modelos/inicioModel.php");
require_once("../core/fbasic.php");

//--Declaraciones
$mensajes = array();
$arreglo_datos = helper_userdata();
redireccionar_metodos($arreglo_datos);
//--
function redireccionar_metodos($arreglo_datos){
	switch ($arreglo_datos["accion"]) {
		case 'inicio_session':
			iniciar_session($arreglo_datos);
			break;
		case 'datos_usuario':
			obtener_datos_usuarios();
			break;
		case 'cerrar_session':
			cerrar_session();
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
		if(array_key_exists('usuario', $_POST)){
			$user_data["usuario"] = $_POST["usuario"];
		}
		if(array_key_exists('password', $_POST)){
			$user_data["password"] = $_POST["password"];
		}	
		//--
	}
	return $user_data;
}
//------------------------------------------------------
function iniciar_session($arreglo_datos){
	$recordset = array();
	$arreglo = array();
	$arreglo_us = array();
	$rs =array();
	$obj = new inicioModel();
	$recordset = $obj->inicio_session($arreglo_datos);
	if($recordset=="error"){
		$arreglo['mensaje']=0;//Caso error....
	}else{
		if($recordset[0][0]>0){
			$arreglo_us = $obj->obtener_datos_us($arreglo_datos['usuario']);
			$_SESSION['login'] = $arreglo_datos['usuario'];
			$_SESSION['tipo_usuario'] = $arreglo_us[0][2];
			$_SESSION['activo'] = true;
			$_SESSION['id'] = $arreglo_us[0][0];
			$_SESSION['id_persona'] = $arreglo_us[0][3];
			$_SESSION['id_unidad_Administrativa'] = $arreglo_us[0][4];
			$_SESSION['nombres_persona'] = $arreglo_us[0][5];
			$arreglo['mensaje'] = 1; //Inicio session con exito....
			//--Bloque de auditoria
			$rs = registrar_auditoria($_SESSION['id'],'Inicio de sesión','','0','Acceso al sistema');
			if($rs[0]==0){
				$arreglo['mensaje'] = 3; //Error en registro de auditoria....
			}
			//--
		}else{
			$arreglo['mensaje'] = 2; //No se encuentran datos asociados....
		}
	}
	die(json_encode($arreglo));
}
//--------------------------------------------------------
function obtener_datos_usuarios(){
	$recordset = array();
	$recordset["nombre_usuario"] = $_SESSION["login"];
	$recordset["tipo_usuario"] = $_SESSION["tipo_usuario"];
	$recordset["id"] = $_SESSION["id"];
	$recordset["id_unidad_Administrativa"] = $_SESSION["id_unidad_Administrativa"];
	if(isset($_SESSION["id"])){
		//--Consulto los permisos
		$obj =  new inicioModel();
		$permisos = $obj->ver_permisos($recordset["id"]);
		$recordset["permisos"] = $permisos;
		//--
		die(json_encode($recordset));
	}else{
		cerrar_session();
	}	
}
//--------------------------------------------------------
function cerrar_session(){
	$arreglo = array();
	unset($_SESSION["login"]);
	unset($_SESSION["tipo_usuario"]);
	unset($_SESSION["id"]);
	session_destroy();
	$arreglo["cerrado"] = "cerrado";			
	die(json_encode($arreglo));
}
//--------------------------------------------------------
?>