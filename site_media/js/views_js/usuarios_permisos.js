//--Bloque de eventos
cargar_select_usuarios();
cargar_select_pantallas();
$("#btn_guardar_us_permiso").click(function(e){
	e.preventDefault();
	var accion = "registrar_us_permisos";
	var usuarios = $("#select_usuario").val();
	var pantallas = $("#select_pantallas").val();
	var estatus = $("#select_estatus").val();
	var id_us_permiso = $("#id_us_permiso").val();
	var data = {
					'accion':accion,
					'usuarios':usuarios,
					'pantallas':pantallas,
					'estatus':estatus,
					'id_us_permiso':id_us_permiso
	}
	if(validar_usuarios_permisos()==true){
		$.ajax({
				url:'./controladores/usuarioController.php',
				type:'POST',
				cache:false,
				data:data,
				error:function(resp){
					console.log(resp);
				},
				success:function(resp){
					var recordset = $.parseJSON(resp);
					//alert(recordset);
					if(recordset[0]=='1'){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-check'></i> Registro exitoso", "alert-success");
						limpiar_us();
					}else
					if(recordset[0]=='0'){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Error en proceso de registro", "alert-danger");
					}else
					if(recordset[0]=='2'){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-check'></i> Actualizaci&oacute;n exitosa", "alert-success");
						limpiar_us();
					}else
					if(recordset[0]=='3'){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Error en proceso de actualizaci&oacute;n", "alert-danger");
					}else
					if(recordset[0]=='4'){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ya se encuentra asignado dicho permiso", "alert-danger");
					}else
					if(recordset[0]=='5'){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> No se encuentra el registro a modificar", "alert-danger");
					}
				}
		});
	}
});
$("#btn_limpiar").click(function(){
	limpiar_us();
});
function cargar_select_usuarios(){
	var accion = "consultar_select_usuarios_permisos";
	var data = {
					'accion':accion
	};
	$.ajax({
				url:'./controladores/usuarioController.php',
				type:'POST',
				cache:false,
				data:data,
				error:function(resp){
					console.log(resp);
				},
				success:function(resp){
					var recordset = $.parseJSON(resp);
					$("#select_usuario").html(recordset["opciones"])
				}
	});
}
function cargar_select_pantallas(){
	var accion = "consultar_select_pantallas_permisos";
	var data = {
					'accion':accion
	};
	$.ajax({
				url:'./controladores/usuarioController.php',
				type:'POST',
				cache:false,
				data:data,
				error:function(resp){
					console.log(resp);
				},
				success:function(resp){
					var recordset = $.parseJSON(resp);
					$("#select_pantallas").html(recordset["opciones"])
				}
	});
}
//-----------------------------------------------------------
function validar_usuarios_permisos(){
	
	if($("#select_usuario").val()=="0"){
		mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Debe seleccionar un usuario", "alert-danger");
		return false;
	}else
	if($("#select_pantallas").val()=="0"){
		mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Debe seleccionar una pantalla", "alert-danger");
		return false;
	}
	else
	if($("#select_estatus").val()=="0"){
		mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Debe seleccionar un estatus", "alert-danger");
		return false;
	}else{
		return true;
	}

}
//---------------------------------------------------------------------------
function limpiar_us(){
	$("#id_us_permiso").val("");
	$("#select_usuario,#select_pantallas,#select_estatus").val(0);
}
//-----------------------------------------------------------