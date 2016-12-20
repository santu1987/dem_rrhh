<?php
require_once("../modelos/usuarioModel.php");
require_once("../vistas_logicas/usuariosView.php");
//--Declaraciones
$mensajes = array();
$arreglo_datos = helper_userdata();
redireccionar_metodos($arreglo_datos);
//--
function redireccionar_metodos($arreglo_datos){
	switch ($arreglo_datos["accion"]) {
		case 'registrar_us':
			registrar_us($arreglo_datos);
			break;
		case 'consultar_select_tipous':
			consultar_select_tipous();
			break;
		case 'consultar_listado_us':
			consultar_listado_us();
			break;
		case 'activar_usuario':
			activar_usuario($arreglo_datos);
			break;
		case 'consultar_select_usuarios_permisos':
			consultar_select_usuarios_permisos();
			break;	
		case 'consultar_select_pantallas_permisos':
			consultar_select_pantallas_permisos();
			break;
		case 'registrar_us_permisos':
			registrar_us_permisos($arreglo_datos);
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
		if(array_key_exists('login', $_POST)){
			$user_data["login"] = $_POST["login"];
		}
		if(array_key_exists('pass', $_POST)){
			$user_data["pass"] = $_POST["pass"];
		}
		if(array_key_exists('pass_rep', $_POST)){
			$user_data["pass_rep"] = $_POST["pass_rep"];
		}
		if(array_key_exists('tipo_us', $_POST)){
			$user_data["tipo_us"] = $_POST["tipo_us"];
		}
		if(array_key_exists('id_us', $_POST)){
			$user_data["id_us"] = $_POST["id_us"];
		}			
		if(array_key_exists('usuarios', $_POST)){
			$user_data["usuarios"] = $_POST["usuarios"];
		}
		if(array_key_exists('pantallas', $_POST)){
			$user_data["pantallas"] = $_POST["pantallas"];
		}
		if(array_key_exists('id_us_permiso', $_POST)){
			$user_data["id_us_permiso"] = $_POST["id_us_permiso"];
		}
		if(array_key_exists('estatus', $_POST)){
			$user_data["estatus"] = $_POST["estatus"];
		}
		//--
	}
	return $user_data;
}
//------------------------------------------------------
function consultar_listado_us(){
	$recordset = array();
	$arreglo_datos = array();
	$obj = new usuarioModel();
	$recordset = $obj->consultar_usuarios_lista();
	//die(json_encode($recordset));
	if($recordset!="error"){
		render_vista_consulta("lista_usuarios",$recordset);
	}else{
		$recordset="error";
		die($recordset);
	}
}
//------------------------------------------------------
function consultar_select_tipous(){
	$recordset = array();
	$arreglo = array();
	$obj = new usuarioModel();
	$recordset = $obj->consultar_select_tipous();
	$select_tipous = "<option value='0' >--Seleccione un tipo de usuario--</option>";
	for($i=0;$i<count($recordset);$i++){
		$select_tipous.="<option value='".$recordset[$i][0]."'>".$recordset[$i][1]."</option>";
	}
	$arreglo["opciones"] = $select_tipous;
	die(json_encode($arreglo));
}
//------------------------------------------------------
function registrar_us($arreglo_datos){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new usuarioModel();
	if($arreglo_datos["id_us"]==""){
		//-----------------------
		//--Verifico que no exista un usuario con ese login
		$existe_us = $obj->consultar_existe_us($arreglo_datos);
		if($existe_us[0][0]==0){
		//--Para guardar
			$recordset = $obj->guardar_us($arreglo_datos);
			//die(json_encode($recordset));
			if($recordset==true){
				$arreglo_valor[0]=1;//Registro exitoso...
			}else{
				$arreglo_valor[0]=0;//Ocurrio un error inesperado al registrar...
			}
		}else{
			$arreglo_valor[0]=4;//Ya existe un usuario con ese login	
		}
		
	}
	else if($arreglo_datos["id_us"]!=""){
		//-----------------------
		//--Para actualizar
		//--Verifico que no exista un usuario con ese login y otro id
		$existe_us = $obj->consultar_existe_us2($arreglo_datos);
		if($existe_us[0][0]==0){
			$existe_us_id = $obj->consultar_existe_us_id($arreglo_datos);
			if($existe_us_id[0][0]>0){
				$recordset = $obj->actualizar_us($arreglo_datos);
				//die(json_encode($recordset));
				if($recordset==true){
					$arreglo_valor[0]=2;//Actualizacion exitosa...
				}else{
					$arreglo_valor[0]=3;//Ocurrio un error inesperado al actualizar...
				}
			}	
		}else{
			$arreglo_valor[0]=5;//Existe usuario con ese login y otro id
		}	
		//-----------------------
	}
	die(json_encode($arreglo_valor));
}
//------------------------------------------------------
function activar_usuario($arreglo_datos){
	$recordset = array();
	$arreglo_retorno = array();
	$obj = new usuarioModel();
	$estatus = $obj->consultar_estatus($arreglo_datos["id_us"]);
	if ($estatus!="error"){
	//-----------------------
		if($estatus[0][0]==1){
			$recordset = $obj->activar_inactivar_us($arreglo_datos['id_us'],2);
			$arreglo_retorno[1]="inactivar";
		}else
		if($estatus[0][0]==2){
			$recordset = $obj->activar_inactivar_us($arreglo_datos['id_us'],1);
			$arreglo_retorno[1]="activar";
		}
		//--
		if($recordset==true){
			$arreglo_retorno[0]=1; //Proceso exitoso...
		}else
		if($recordset==false){
			$arreglo_retorno[0]=0; //Error en proceso ...
		}
		//--
		
	//-----------------------
	}else{
		$arreglo_retorno[0] = -1; //Error en consulta de estatus...
	}
	die(json_encode($arreglo_retorno));

}
//------------------------------------------------------
function consultar_select_usuarios_permisos(){
	$recordset = array();
	$arreglo = array();
	$obj = new usuarioModel();
	$recordset = $obj->consultar_usuarios_lista();
	$select_us = "<option value='0' >--Seleccione un usuario--</option>";
	for($i=0;$i<count($recordset);$i++){
		$select_us.="<option value='".$recordset[$i][0]."'>".$recordset[$i][1]."</option>";
	}
	$arreglo["opciones"] = $select_us;
	die(json_encode($arreglo));
}
//------------------------------------------------------
function consultar_select_pantallas_permisos(){
	$recordset = array();
	$arreglo = array();
	$obj = new usuarioModel();
	$recordset = $obj->consultar_pantallas_lista();
	//die(json_encode($recordset));
	$select_pantallas = "<option value='0' >--Seleccione una pantalla--</option>";
	for($i=0;$i<count($recordset);$i++){
		$select_pantallas.="<option value='".$recordset[$i][0]."'>".$recordset[$i][1]."</option>";
	}
	$arreglo["opciones"] = $select_pantallas;
	die(json_encode($arreglo));	
}
//------------------------------------------------------
function registrar_us_permisos($arreglo_datos){
	$recordset = array();
	$arreglo_valor = array();
	$obj = new usuarioModel();
	//-----------------------
	//--Verifico que no exista un usuario con ese login
	$existe_us = $obj->consultar_existe_us_permiso($arreglo_datos);
	//die(json_encode($existe_us));
	if($existe_us[0][0]==0){
	//--Para guardar
		$recordset = $obj->guardar_us_permiso($arreglo_datos);
		//die(json_encode($recordset));
		if($recordset==true){
			$arreglo_valor[0]=1;//Registro exitoso...
		}else{
			$arreglo_valor[0]=0;//Ocurrio un error inesperado al registrar...
		}
	}else{
			$recordset = $obj->actualizar_us_permiso($arreglo_datos);
			//die(json_encode($recordset));
			if($recordset==true){
				$arreglo_valor[0]=2;//Actualizacion exitosa...
			}else{
				$arreglo_valor[0]=3;//Ocurrio un error inesperado al actualizar...
			}	
	}	
	die(json_encode($arreglo_valor));	
}
//------------------------------------------------------
?>