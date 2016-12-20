//-------------------------------
//Bloque de Eventos
//-------------------------------
$(document).ready(function(){

	carga_inicio();
	//$("#cuerpo_principal").load("site_media/templates/empresa.html");
	//--Opciones de menu
	//--
	$("#op_constancias_faov").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		},2000);
		cargar_constancias_faov();
	});
	//--
	$("#op_usuarios_registros").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		},2000);
		carga_usuarios_form();
	});
	//--
	$("#op_usuarios_permisos").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		});
		carga_usuarios_permisos();
	});
	//-- AL pulsar opcion menu de carga de horas extras
	$("#op_carga_horas_extras").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		});
		cargar_registro_horas_extras();
	});
	//-- Al pular la opcion menu de validar horas extras
	$("#op_validar_horas").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		});
		cargar_validacion_horas_extras();
	});
	//-- AL pulsar la opcion menu de carga de dia adicional
	$("#op_carga_dia_adicional").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		});
		carga_dia_adicional();
	});
	//--
	//-- AL pulsar la opcion menu de generar pdf
	$("#op_generar_reporte").click(function(e){
		e.preventDefault();
		setTimeout(function(){
			mensaje_preloader("#campo_mensaje_lista");
		});
		carga_reporte();
	});
	//--
	$(document).on("click",".cerrar_session2",function(){
	//--------------------------------------------
		var accion = "cerrar_session";
		var data = {'accion':accion};
		$.ajax({
					url:'./controladores/inicioController.php',
					type:'POST',
					data:data,
					cache:false,
					error:function(resp){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ocurri&oacute; un error inesperado", "alert-danger");
					},
					success:function(resp){
						var recordset = $.parseJSON(resp);
						if(recordset["cerrado"]=="cerrado"){
							document.forms.form_inicio.action='./index.html';
						    document.forms.form_inicio.submit();
						}
					}
		});
	//--------------------------------------------	
	});
	//--
});
//-------------------------------
//Bloue de funciones
//-------------------------------
function carga_inicio(){
	var accion = "datos_usuario";
	var data = {'accion':accion};
	$.ajax({
				url:'./controladores/inicioController.php',
				type:'POST',
				data:data,
				cache:false,
				error:function(resp){
					mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ocurri&oacute; un error inesperado", "alert-danger");
				},
				success:function(resp){
					var recordset = $.parseJSON(resp);
					if(recordset["cerrado"]=="cerrado"){
						document.forms.form_inicio.action='./index.html';
						document.forms.form_inicio.submit();
					}else{
						$("#nombre_usuario").text(recordset["nombre_usuario"]);
						$("#tipo_usuario,#tipo_usuario2").text(recordset["tipo_usuario"]);
						$("#unidad_administrativa").val(recordset["id_unidad_Administrativa"]);
						var arreglo_permisos = recordset["permisos"];
						establecer_permisos(arreglo_permisos);
					}
					
				}
	});
}
function establecer_permisos(arreglo_permisos){
	var a = 0;
	var arreglo_menu= Array();
	arreglo_menu[0] = "#op_usuarios_registros_li";
	arreglo_menu[1] = "#op_usuarios_permisos_li";
	arreglo_menu[2] = "#op_constancias_li";
	//---Para bloquear...
	for (j=0;j<13;j++){
		$(arreglo_menu[j]).attr("style","display:none");	
	}
	//--Para habilitar...
	for (i=1;i<=13;i++){
		if(arreglo_permisos[0][i]==1){
			$(arreglo_menu[a]).attr("style","display:block");
		}
		a++;	
	}
	//--
}
function activar_btn(seccion){
	$("#op_constancias,#op_usuarios").removeClass("activo_top").removeClass("activo_normal");
	switch(seccion){
		case 'constancia':
			$("#op_constancias").addClass("activo_top");
			break;
		case 'usuarios':
			$("#op_usuarios").addClass("activo_top");
			break;								
	}
}
//-----------------------------------------------------------------
function cargar_lista_nosotros(){
	var accion = "consultar_nosotros";
	var data = {
					'accion':accion
	};
	$.ajax({
				url:'./controladores/nosotrosController.php',
				type:'POST',
				data: data,
				cache:false,
				error:function(resp){
					mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Error inesperado", "alert-danger");
				},
				success:function(resp){
					alert(resp);
					$("#cuerpo_principal").html(resp);
					quitar_preloader();
					//--Para datatable...
					iniciar_datatable();
				}
	});
}
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
function cargar_nos_empresa(){
	$("#cuerpo_principal").load("site_media/templates/nuestra_empresa.html");	
}
//-------------------------------------------------------------------------------
function cargar_nos_mision(){
	$("#cuerpo_principal").load("site_media/templates/mision.html");
}
//-------------------------------------------------------------------------------
function cargar_nos_vision(){
	$("#cuerpo_principal").load("site_media/templates/vision.html");
}
//-------------------------------------------------------------------------------
function cargar_nos_historia(){
	$("#cuerpo_principal").load("site_media/templates/historia.html");	
}
//-------------------------------------------------------------------------------
function cargar_nos_productos(){
	$("#cuerpo_principal").load("site_media/templates/productos.html");
}
//-------------------------------------------------------------------------------
function cargar_contacto(){
	var accion = 'cargar_lista_contactos';
	var data = {'accion':accion};
	$.ajax({
				url:'./controladores/contactosController.php',
				type:'POST',
				data:data,
				cache:false,
				error:function(resp){
					console.log(resp);
				},
				success: function(resp){
					$("#cuerpo_principal").html(resp);
					mensaje_preloader("#campo_mensaje_lista");
					iniciar_datatable();
				}
	});
}
//----------------------------------------------------------------------------------
function carga_usuarios_form(){
	$("#cuerpo_principal").load("site_media/templates/usuarios.html");
}
//----------------------------------------------------------------------------------
function carga_usuarios_permisos(){
	$("#cuerpo_principal").load("site_media/templates/usuarios_permisos.html");
}
//----------------------------------------------------------------------------------
function cargar_registro_horas_extras(){
	$("#cuerpo_principal").load("site_media/templates/carga_horas_extras.html");
}
//----------------------------------------------------------------------------------
function cargar_validacion_horas_extras(){
	$("#cuerpo_principal").load("site_media/templates/validar_horas_extras.html");
}
//----------------------------------------------------------------------------------
function carga_dia_adicional(){
	$("#cuerpo_principal").load("site_media/templates/carga_dia_adicional.html");
}
//----------------------------------------------------------------------------------
function carga_reporte(){
	$("#cuerpo_principal").load("site_media/templates/carga_reporte.html");
}
//----------------------------------------------------------------------------------