//--Bloque de eventos
cargar_select_tipo_us();
$("#ver_pass").click(function(e){
	e.preventDefault();
	if($("#ojo_pass").hasClass("fa-eye")){
			$("#ver_pass").html('<i id="ojo_pass" class="fa fa-eye-slash" aria-hidden="true"></i>');
			$("#ver_pass").attr("title","No ver password");
			$("#text_pass").attr("type","text");
	}else if($("#ojo_pass").hasClass("fa-eye-slash")){
			$("#ver_pass").html('<i id="ojo_pass" class="fa fa-eye" aria-hidden="true"></i>');
			$("#ver_pass").attr("title","Ver password");
			$("#text_pass").attr("type","password");
	}
});
$("#ver_pass_rep").click(function(e){
	e.preventDefault();
	if($("#ojo_pass2").hasClass("fa-eye")){
			$("#ver_pass_rep").html('<i id="ojo_pass2" class="fa fa-eye-slash" aria-hidden="true"></i>');
			$("#ver_pass_rep").attr("title","No ver password");
			$("#text_pass_rep").attr("type","text");
	}else if($("#ojo_pass2").hasClass("fa-eye-slash")){
			$("#ver_pass_rep").html('<i id="ojo_pass2" class="fa fa-eye" aria-hidden="true"></i>');
			$("#ver_pass_rep").attr("title","Ver password");
			$("#text_pass_rep").attr("type","password");
	}
});
$("#btn_guardar_us").click(function(e){
	e.preventDefault();
	var accion = "registrar_us";
	var login = $("#text_login").val();
	login = login.toLowerCase();
	var pass = $("#text_pass").val();
	var pass_rep = $("#text_pass_rep").val();
	var tipo_us = $("#select_tipo_usuario").val();
	var id_us = $("#id_us").val();
	var data = {
					'accion':accion,
					'login':login,
					'pass':pass,
					'pass_rep':pass_rep,
					'tipo_us':tipo_us,
					'id_us':id_us
	}
	if(validar_usuarios()==true){
		$.ajax({
				url:'./controladores/usuarioController.php',
				type:'POST',
				cache:false,
				data:data,
				error:function(resp){
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
				},
				success:function(resp){
					var recordset = $.parseJSON(resp);
					//alert(recordset);
					if(recordset[0]=='1'){
						carga_pnoty_success("Informaci&oacute;n:","Registro exitoso");
						limpiar_us();
					}else
					if(recordset[0]=='0'){
						carga_pnoty_danger("Error:","Error en proceso de registro");
					}else
					if(recordset[0]=='2'){
						carga_pnoty_success("Informaci&oacute;n:","actualizaci&oacuten exitosa");
						limpiar_us();
					}else
					if(recordset[0]=='3'){
						carga_pnoty_danger("Error:","Error en proceso de actualizaci&oacute;n");
					}
					else
					if(recordset[0]=='4'){
						carga_pnoty_info("Informaci&oacute;n:","Ya existe un usuario con ese login");
					}
					else
					if(recordset[0]=='5'){
						carga_pnoty_info("Informaci&oacute;n:","Ya existe un usuario con ese login");
					}
					else
					if(recordset[0]=='6'){
						carga_pnoty_info("Informaci&oacute;n:","No existe el usuario");
					}
				}
		});
	}
});
$("#btn_limpiar").click(function(){
	limpiar_us();
});
$("#btn_ver_listado_us").click(function(e){
	e.preventDefault();
	cargar_lista_us();
	//Cargar datos tabla
	setTimeout(function(){
		quitar_preloader();
	},2000);
});
//--Bloque de funcion
function cargar_lista_us(){
	var accion = "consultar_listado_us";
	var data = {'accion':accion};
	$.ajax({
				url:'./controladores/usuarioController.php',
				type:'POST',
				cache:false,
				data:data,
				error:function(resp){
					console.log(resp);
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
				},
				success:function(resp){
					if(resp=="error"){
						carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
					}else{
						$("#cuerpo_principal").html(resp);
						iniciar_datatable();
						mensaje_preloader("#campo_mensaje_lista");
					}
				}
	});
}
function cargar_select_tipo_us(){
	var accion = "consultar_select_tipous";
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
					$("#select_tipo_usuario").html(recordset["opciones"])
				}
	});
}
//-----------------------------------------------------------
function validar_usuarios(){
	var pass =$("#text_pass").val();
	var pass_rep = $("#text_pass_rep").val();
	if($("#select_tipo_usuario").val()=="0"){
		carga_pnoty_info("Informaci&oacute;n:","Debe seleccionar el tipo de usuario");
		return false;
	}else
	if($("#text_login").val()==""){
		carga_pnoty_info("Informaci&oacute;n:","Debe ingresar el login");
		return false;
	}
	else
	if((pass.length<8)||(pass_rep.length<8)){
		carga_pnoty_info("Informaci&oacute;n:"," El password debe ser de 8 caracteres alfanum&eacute;ricos");
		return false;
	}	
	else	
	if($("#text_pass").val()==""){
		carga_pnoty_info("Informaci&oacute;n:"," Debe ingresar el password");
		return false;
	}else
	if($("#text_pass_rep").val()==""){
		carga_pnoty_info("Informaci&oacute;n:"," Debe repetir el password");
		return false;
	}else
	if(($("#text_pass_rep").val())!=($("#text_pass").val())){
		carga_pnoty_info("Informaci&oacute;n:"," Los passwords deben coincidir");
		return false;
	}else{
		return true;
	}

}
//---------------------------------------------------------------------------
function limpiar_us(){
	$("#text_login,#text_pass,#text_pass_rep").val("");
	$("#select_tipo_usuario").val(0);
}
//-----------------------------------------------------------